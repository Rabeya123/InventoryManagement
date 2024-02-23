<?php

namespace App\Http\Controllers;

use App\Models\ProductIdentifier;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    public function index()
    {
        $UserProductProductStatus = DB::select('
            SELECT 	    U.id AS user_id,
                        U.name AS user_name,
                        P.name AS product_name, P.has_identifier, P.id AS product_id,
                        UN.name AS unit_name,
                        MAX(PI.created_at) AS created_time,
                        COUNT(0) AS TerminalReceivedCount,
                        (
                            SELECT 		COUNT(0)
                            FROM 		product_identifiers AS PI2
                        	WHERE 		PI2.product_id = P.id
		                        AND 	PI2.float_user_id = U.id
                                AND 	PI2.CustomerID IS NOT NULL
                        ) AS TerminalInstalledCount
            FROM        product_identifiers AS PI
            LEFT JOIN 	requestion_product_identifer AS RPI ON RPI.indentifier_id = PI.id
            LEFT JOIN 	products AS P ON P.id = PI.product_id
            LEFT JOIN 	users AS U ON U.id = PI.float_user_id
            LEFT JOIN 	units as UN ON UN.id = P.unit_id
            WHERE 	    TRUE
            AND 	    PI.float_user_id IS NOT NULL
            GROUP BY 	PI.float_user_id, PI.product_id
        ');

        return view('user_product.index',[
            'UserProductProductStatus' => $UserProductProductStatus
        ]);
    }
}
