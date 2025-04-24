<?php

namespace App\Imports;

use App\Models\JobWiseProduction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class JobWiseProductionImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row)
        {
            if($key == 0){
                continue;
            }

            JobWiseProduction::create([
                'id' => $row[0],
                'place' => $row[1],
                'job_no' => $row[2],
                'crm_id' => $row[3],
                'payment_received_manufacturing_date' => $row[4],
                'crm_confirmation_date' => $row[5],
                'customer_id' => $row[6],
                'addressu' => $row[7],
                'specifications' => $row[8],

                'car_bracket' => $row[9],
                'car_bracket_readiness_status' => $row[10],
                'car_bracket_readiness_date' => $row[11],
                'cwt_bracket' => $row[12],
                'cwt_bracket_readiness_status' => $row[13],
                'cwt_bracket_readiness_date' => $row[14],
                'ld_opening' => $row[15],
                'ld_finish' => $row[16],
                'ld_frame_status' => $row[17],
                'ld_frame_readiness_date' => $row[18],
                'ld_status' => $row[19],
                'ld_readiness_date' => $row[20],
                'comments' => $row[21],

                'machine_channel_type' => $row[22],
                'machine_channel_readiness_status' => $row[23],
                'machine_channel_readiness_date' => $row[24],
                'machine' => $row[25],
                'machine_readiness_status' => $row[26],
                'machine_readiness_date' => $row[27],
                'car_frame' => $row[28],
                'car_frame_readiness_status' => $row[29],
                'car_frame_readiness_date' => $row[30],
                'cwt_frame' => $row[31],
                'cwt_frame_readiness_status' => $row[32],
                'cwt_frame_readiness_date' => $row[33],
                'rope_available' => $row[34],
                'osg_assy_available' => $row[35],
                'comment_after_osg' => $row[36],

                'cabin' => $row[37],
                'cabin_readiness_status' => $row[38],
                'cabin_readiness_date' => $row[39],
                'controller' => $row[40],
                'controller_readiness_status' => $row[41],
                'controller_readiness_date' => $row[42],
                'car_door_opening' => $row[43],
                'car_door_finish' => $row[44],
                'car_door_readiness_status' => $row[45],
                'car_door_readiness_date' => $row[46],
                'cop_lop' => $row[47],
                'cop_lop_readiness_status' => $row[48],
                'cop_lop_readiness_date' => $row[49],
                'harness' => $row[50],
                'harness_readiness_status' => $row[51],
                'harness_readiness_date' => $row[52],
                'commentscommentscomments' => $row[53],

                'is_revised' => $row[54],
                'full_dispatched_date1' => $row[55],
                'car_bracket_available_status' => $row[56],
                'car_bracket_available_date' => $row[57],
                'car_bracket_dispatch_status' => $row[58],
                'car_bracket_dispatch_date' => $row[59],
                'cwt_bracket_available_status' => $row[60],
                'cwt_bracket_available_date'=> $row[61],
                'cwt_bracket_dispatch_status'=> $row[62],
                'cwt_bracket_dispatch_date'=> $row[63],
                'ld_frame_received_date'=> $row[64],
                'ld_frame_dispatch_status'=> $row[65],
                'ld_frame_dispatch_date'=> $row[66],
                'ld_received_date'=> $row[67],
                'ld_dispatch_status'=> $row[68],
                'ld_dispatch_date'=> $row[69],

                'is_checkedbox'=> $row[70],
                'full_dispatched_date2'=> $row[71],
                'machine_channel_received_date'=> $row[72],
                'machine_channel_dispatch_status'=> $row[73],
                'machine_channel_dispatch_date'=> $row[74],
                'machine_available_date'=> $row[75],
                'machine_dispatch_status'=> $row[76],
                'machine_dispatch_date'=> $row[77],
                'car_frame_received_date'=> $row[78],
                'car_frame_dispatch_status'=> $row[79],
                'car_frame_dispatch_date'=> $row[80],
                'cwt_frame_received_date'=> $row[81],
                'cwt_frame_dispatch_status'=> $row[82],
                'cwt_frame_dispatch_date'=> $row[83],
                'rope_available_date'=> $row[84],
                'rope_dispatch_status'=> $row[85],
                'rope_dispatch_date'=> $row[86],
                'osg_assy_available_date'=> $row[87],
                'osg_assy_dispatch_status'=> $row[88],
                'osg_assy_dispatch_date'=> $row[89],

                'is_check'=> $row[90],
                'full_dispatched_date3'=> $row[91],
                'cabin_received_date'=> $row[92],
                'cabin_dispatch_status'=> $row[93],
                'cabin_dispatch_date'=> $row[94],
                'controller_available_date'=> $row[95],
                'controller_dispatch_status'=> $row[96],
                'controller_dispatch_date'=> $row[97],
                'car_door_received_date'=> $row[98],
                'car_door_dispatch_status'=> $row[99],
                'car_door__dispatch_date'=> $row[100],
                'cop_lop_received_date'=> $row[101],
                'cop_lop_dispatch_status'=> $row[102],
                'cop_lop__dispatch_date'=> $row[103],
                'harness_available_date'=> $row[104],
                'harness_dispatch_status'=> $row[105],
                'harness_dispatch_date'=> $row[106],
            ]);
        }
    }
}