<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelToColleciton implements ToCollection, WithHeadingRow
{
    public $data;
    public $ExitsIndentifers;
    public $product_id;

    public function __construct($ExitsIndentifers, $product_id)
    {
        $this->ExitsIndentifers = $ExitsIndentifers;
        $this->product_id = $product_id;
    }

    public function collection(Collection $rows)
    {
      //  dd($this->ExitsIndentifers);
        foreach($rows as $row) { //dd($row['code'], $this->ExitsIndentifers->toArray());
            if(COUNT($this->ExitsIndentifers) > 0){
                
                if(in_array($row['code'], $this->ExitsIndentifers)){
                    $row['is_code_exits'] = 1;
                }else{
                    $row['is_code_exits'] = 0;
                }

                if(in_array($row['secondary_code'], $this->ExitsIndentifers)){
                    $row['is_secondary_code_exits'] = 1;
                }else{
                    $row['is_secondary_code_exits'] = 0;
                }
               
            }else{
                $row['is_code_exits'] = 0;
                $row['is_secondary_code_exits'] = 0;
            }
            $row['product_id'] = $this->product_id;
            // $this->data->push($row);
            $this->data[] = $row;
            // array_push($this->data, $row);
        }
        //Check
        // array_push($this->data, )
        // $this->data = $rows;
    }
}

//code for excle
// if($request->type_id == 3){

//     $imported_data = [];
    
//     for ($i=0; $i <count($request->product_id) ; $i++) { 
//         if(!empty($request->identifier[$i])){
//             $ExitsIndentifers = DB::table('product_identifiers')
//                 ->whereIn('code', $imported_data)
//                 ->pluck('code');
//             $import = new ExcelToColleciton($ExitsIndentifers, $request->product_id);
//             Excel::import($import, $request->identifier[$i]); //dd();
//             $imported_data = array_merge($imported_data, $import->data);
//         }
//     }

//     //Check exits identifers if any 

//     $ExitsIndentifers = DB::table('product_identifiers')
//         ->whereIn('code', $imported_data)
//         ->pluck('code');
//         // ->pluck('code');

//     //Check duplicate number

//     dd($ExitsIndentifers, $imported_data[0]);

//     return 'working';
// }
// dd('Working');
