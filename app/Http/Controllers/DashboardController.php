<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerBill;
use Illuminate\Http\Request;
use Auth;
use Toastr;
use PDF;
use App\Models\User;
use Illuminate\Support\Carbon;
use Hash;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $TotalProductStatus = DB::select("
                SELECT
                            SUM(IF(IH.type = 'IN', IH.quantity, 0)) AS TotalIn,
                            SUM(IF(IH.type = 'OUT', IH.quantity, 0)) AS TotalOut
                FROM 	    inventory_histories AS IH;
        ");
        $data['TotalProductInCount'] = isset($TotalProductStatus[0]->TotalIn) ? $TotalProductStatus[0]->TotalIn : 0;
        $data['TotalProductOutCount'] = isset($TotalProductStatus[0]->TotalOut) ? $TotalProductStatus[0]->TotalOut : 0;

        $TotalProductStatus = DB::select("
                SELECT      SUM(UP.quantity) as Total
                FROM        user_products AS UP;
        ");

        $data['TotalFloatingCount'] = DB::select("
                SELECT 		COUNT(0) AS Total from product_identifiers AS PI
                LEFT JOIN 	requestion_product_identifer AS RPI ON RPI.indentifier_id = PI.id
                WHERE 		PI.float_user_id IS NOT NULL
                    AND 	PI.CustomerID IS NULL;
        ")[0]->Total;
        // return  $data['TotalFloatingCount'];
        $data['ProductMovementDaily'] = DB::select("
                SELECT 		P.name AS ProductName,
                            IFNULL(UP.floating_quantity, 0) AS FloatingQuantity,
                            SUM(IF(IH.type = 'IN', IH.quantity, 0)) AS ProductIN,
                            SUM(IF(IH.type = 'OUT', IH.quantity, 0)) AS ProductOUT,
                            DATE_FORMAT(IH.date, '%d-%m-%Y') AS Date
                FROM 		inventory_histories AS IH
                LEFT JOIN 	products AS P ON P.id = IH.product_id
                LEFT JOIN 	locations AS L ON L.id = IH.location_id
                LEFT JOIN 	(
                                SELECT MAX(UPS.id), UPS.product_id as user_product_id, UPS.quantity AS floating_quantity FROM user_products AS UPS
                            ) AS UP ON UP.user_product_id = IH.product_id
                GROUP BY 	IH.date
                ORDER BY    IH.date
                LIMIT       30;
        "); //return  //$data['ProductMovementDaily'];

        #Start Only Identifier product
        #Total Purchase value
        $data['TotalProductPurchaseAmount'] = DB::select("
                SELECT 		SUM(PB.purchase_price) AS TotalProductPurchaseAmount
                FROM        product_identifiers AS PI
                LEFT JOIN 	product_batchs AS PB ON PB.id = PI.batch_id
                WHERE 	    PI.is_active = 1;
        ")[0]->TotalProductPurchaseAmount;

        #Floating product total purchase amount identigfier category
        $data['TotalProductPurchaseFloatingAmount'] = DB::select("
                SELECT 		SUM(PB.purchase_price) AS TotalProductPurchaseFloatingAmount
                FROM        product_identifiers AS PI
                LEFT JOIN 	product_batchs AS PB ON PB.id = PI.batch_id
                WHERE 	    PI.float_user_id IS NOT NULL
                    AND 	PI.CustomerID IS NULL;
        ")[0]->TotalProductPurchaseFloatingAmount;

        #Inhouse product total purchase amount identigfier category
        $data['TotalProductIndentifierPurchaseAmount'] = DB::select("
                SELECT 		SUM(PB.purchase_price) AS TotalProductIndentifierPurchaseAmount
                FROM        product_identifiers AS PI
                LEFT JOIN 	product_batchs AS PB ON PB.id = PI.batch_id
                WHERE 	    PI.float_user_id IS NULL
                    AND 	PI.CustomerID IS NULL
        ")[0]->TotalProductIndentifierPurchaseAmount;
         #END Only Identifier product

        $ProductCurrentPosition = DB::select("
                SELECT 		    P.name AS ProductName,
                                @ProductIN := SUM(IF(IH.type = 'IN', IH.quantity, 0)) AS ProductIN,
                                @ProductOUT := SUM(IF(IH.type = 'OUT', IH.quantity, 0)) AS ProductOUT
                FROM 		    inventory_histories AS IH
                LEFT JOIN 	    products AS P ON P.id = IH.product_id
                GROUP BY 	    IH.product_id;
        ");

        if(COUNT($ProductCurrentPosition) > 0){
            foreach($ProductCurrentPosition as $ProductCurrent){ //dd($ProductCurrent->ProductIN);
                $ProductCurrent->TotalCount =  $ProductCurrent->ProductIN - $ProductCurrent->ProductOUT;
                unset($ProductCurrent->ProductIN, $ProductCurrent->ProductOUT);
                $data['ProductCurrentPosition'][] = $ProductCurrent;
             }
        }else{
            $data['ProductCurrentPosition'] = [];
        }

        return view('dashboard', $data);
    }

    public function profile(User $User)
    {
        return view('profile', [
            'User' => User::where('id', Auth::user()->id)->first()
        ]);
    }

    public function update(Request $request){

        $this->validate($request, [
            'name'    => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id],
            'mobile'        => ['required', 'string', 'max:255', 'unique:users,mobile,'.Auth::user()->id],
            'is_active'    =>['required'],
            'password'      => ['sometimes', 'nullable' , 'min:6', 'confirmed']
        ]);

        User::find(Auth::user()->id)->update([
            'name'    => $request['name'],
            'id'   => $request['id'],
            'email'         => $request['email'],
            'mobile'        => $request['mobile'],
            'is_active'     => $request['is_active']
        ]);

        if($request['password']){
            User::find(Auth::user()->id)->update([
                'password'      => Hash::make($request['password']),
            ]);
        }

        Toastr::success('Profile has been updated succesfully!', 'Title', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }
}
