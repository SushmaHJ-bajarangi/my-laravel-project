<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Response;


class PricingMasterController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('pricing_master.index');
//        $data = ManufactureStatus::where('is_deleted',0)->get();
//        return view('pricing_master.index')
//            ->with('data', $data);

    }

    public function create()
    {
        return view('pricing_master.create');
    }

    public function calculate_price(Request $request)
    {
        $data = [];
        $base_price = $request->basic_price;

        $H4 = 500; // from pricing
        $L4 = 1000; // from pricing
        $P4 = 1500; // from pricing
        $T4 = 2500; // from pricing
        $X4 = 3000; // from pricing
        $AB4 = 3500; // from pricing
        $AF4 = 4500; // from pricing
        $D28 = 1000; // from pricing
        $D29 = 1000; // from pricing
        $D30 = 1500; // from pricing
        $D31 = 1500; // from pricing
        $D32 = 1500; // from pricing
        $D33 = 2000; // from pricing
        $D34 = 2000; // from pricing
        $D35 = 2000; // from pricing
        $D36 = 2000; // from pricing
        $D37 = 2000; // from pricing
        $D38 = 2000; // from pricing
        $D39 = 2000; // from pricing
        $D40 = 2000; // from pricing
        $D41 = 2000; // from pricing
        $D42 = 2000; // from pricing
        $D43 = 2000; // from pricing
        $D6 = 1000; // from pricing
        $D7 = 1000; // from pricing
        $D8 = 1500; // from pricing
        $D9 = 1500; // from pricing
        $D10 = 1500; // from pricing
        $D11 = 1500; // from pricing
        $D12 = 1500; // from pricing
        $D13 = 1500; // from pricing
        $D14 = 1500; // from pricing
        $D15 = 1500; // from pricing
        $D16 = 1500; // from pricing
        $D17 = 1500; // from pricing
        $D18 = 1500; // from pricing
        $D19 = 1500; // from pricing
        $D20 = 1500; // from pricing
        $D21 = 1500; // from pricing
        $D74 = 1500; // from pricing
        $D75 = 1500; // from pricing
        $D76 = 1500; // from pricing
        $D77 = 2000; // from pricing
        $D78 = 2000; // from pricing
        $D79 = 2000; // from pricing
        $D80 = 2000; // from pricing
        $D81 = 2000; // from pricing
        $D82 = 2000; // from pricing
        $D83 = 2000; // from pricing
        $D84 = 2000; // from pricing
        $D85 = 2000; // from pricing
        $D86 = 2000; // from pricing
        $D87 = 2000; // from pricing
        $E49 = 25500;
        $F49 = 3000;
        $K48 = 28000;
        $D49 = 0;
        $L49 = 3000;
        $Q48 = 33500;
        $R49 = 3000;
        $X49 = 3000;
        $W48 = 41500;

        if ($request->elevator_type == 'passenger_lift') {
            $no_of_passenger = $request->no_of_passengers;
            $no_of_stops_p = $request->no_of_stops_p;
            $area_of_installation_p = $request->area_of_installation_p;

            $F8 = $H4;
            $F9 = $L4;
            $F10 = $L4;
            $F11 = $P4;
            $F16 = $T4;
            $F21 = $X4;
            $F24 = $AB4;
            $F7 = $H4;
            $F27 = $AF4;
            $G8 = $F8;
            $G9 = $F9 + $G8;
            $G10 = $F10 + $G8;
            $G11 = $F11 + $G10;
            $G12 = $G11;
            $G13 = $G12;
            $G14 = $G13;
            $G15 = $G14;
            $G16 = $G15 + $F16;
            $G17 = $G16;
            $G18 = $G17;
            $G19 = $G18;
            $G20 = $G19;
            $G21 = $G20 + $F21;
            $G22 = $G21;
            $G23 = $G22;
            $G24 = $G23 + $F24;
            $G25 = $G24;
            $G26 = $G22;
            $G27 = $G26 + $F27;
            $G28 = $G27;
            $G29 = $G28;
            $G30 = $G29;
            $G6 = 0;
            $G7 = $F7;
            if ($no_of_passenger < 7) {
                $o36 = $G6;
            }  elseif ($no_of_passenger == 7) {
                $o36 =  $G7;
            } elseif ($no_of_passenger == 8) {
                $o36 = $G8;
            } elseif ($no_of_passenger == 9) {
                $o36 =  $G9;
            } elseif ($no_of_passenger == 10) {
                $o36 =  $G10;
            } elseif ($no_of_passenger == 11) {
                $o36 =  $G11;
            } elseif ($no_of_passenger == 12) {
                $o36 =  $G12;
            } elseif ($no_of_passenger == 13) {
                $o36 =  $G13;
            } elseif ($no_of_passenger == 14) {
                $o36 =  $G14;
            } elseif ($no_of_passenger == 15) {
                $o36 =  $G15;
            } elseif ($no_of_passenger == 16) {
                $o36 =  $G16;
            } elseif ($no_of_passenger == 17) {
                $o36 =  $G17;
            } elseif ($no_of_passenger == 18) {
                $o36 =  $G18;
            } elseif ($no_of_passenger == 19) {
                $o36 =  $G19;
            } elseif ($no_of_passenger == 20) {
                $o36 =  $G20;
            } elseif ($no_of_passenger == 21) {
                $o36 =  $G21;
            } elseif ($no_of_passenger == 22) {
                $o36 =  $G22;
            } elseif ($no_of_passenger == 23) {
                $o36 =  $G23;
            } elseif ($no_of_passenger == 24) {
                $o36 =  $G24;
            } elseif ($no_of_passenger == 25) {
                $o36 =  $G25;
            } elseif ($no_of_passenger == 26) {
                $o36 =  $G26;
            } elseif ($no_of_passenger == 27) {
                $o36 =  $G27;
            } elseif ($no_of_passenger == 28) {
                $o36 = $G28;
            } elseif ($no_of_passenger == 29) {
                $o36 =  $G29;
            } elseif ($no_of_passenger == 30) {
                $o36 = $G30;
            } else {
                $o36 =  0;
            }

            $E36 = 0;  //from new working
            $E37 = $D28;
            $E38 = $D29 + $E37;
            $E39 = $D30 + $E38;
            $E40 = $D31 + $E39;
            $E41 = $D32 + $E40;
            $E42 = $D33 + $E41;
            $E43 = $D34 + $E42;
            $E44 = $D35 + $E43;
            $E45 = $D36 + $E44;
            $E46 = $D37 + $E45;
            $E47 = $D38 + $E46;
            $E48 = $D39 + $E47;
            $E49 = $D40 + $E48;
            $E50 = $D41 + $E49;
            $E51 = $D42 + $E50;
            $E52 = $D43 + $E51;

            if ($no_of_stops_p < 5) {
                $o35 = $E36;
            } elseif ($no_of_stops_p == 5) {
                $o35 = $E37;
            } elseif ($no_of_stops_p == 6) {
                $o35 = $E38;
            } elseif ($no_of_stops_p == 7) {
                $o35 = $E39;
            } elseif ($no_of_stops_p == 8) {
                $o35 = $E40;
            } elseif ($no_of_stops_p == 9) {
                $o35 = $E41;
            } elseif ($no_of_stops_p == 10) {
                $o35 = $E42;
            } elseif ($no_of_stops_p == 11) {
                $o35 = $E43;
            } elseif ($no_of_stops_p == 12) {
                $o35 = $E44;
            } elseif ($no_of_stops_p == 13) {
                $o35 = $E45;
            } elseif ($no_of_stops_p == 14) {
                $o35 = $E46;
            } elseif ($no_of_stops_p == 15) {
                $o35 = $E47;
            } elseif ($no_of_stops_p == 16) {
                $o35 = $E48;
            } elseif ($no_of_stops_p == 17) {
                $o35 = $E49;
            } elseif ($no_of_stops_p == 18) {
                $o35 = $E50;
            } elseif ($no_of_stops_p == 19) {
                $o35 = $E51;
            } elseif ($no_of_stops_p == 20) {
                $o35 = $E52;
            } else {
                $o35 = 0;
            }

            $o37 = $base_price + $o35 + $o36;

            if ($area_of_installation_p == "<=100") {
                $o38 =  round($o37 * 1.5);
            } elseif ($area_of_installation_p == ">>100 & <=200") {
                $o38 =  round($o37 * 1.6);
            } elseif ($area_of_installation_p == ">>200 & <=300") {
                $o38 =  round($o37 * 1.8);
            } elseif ($area_of_installation_p == ">300") {
                $o38 =  round($o37 * 2);
            } else {
                $o38 = 0;
            }

            $E4 = 0; // from new working
            $E5 = $D6;
            $E6 = $E5 + $D7;
            $E7 = $E6 + $D8;
            $E8 = $E7 + $D9;
            $E9 = $E8 + $D10;
            $E10 = $E9 + $D11;
            $E11 = $E10 + $D12;
            $E12 = $E11 + $D13;
            $E13 = $E12 + $D14;
            $E14 = $E13 + $D15;
            $E15 = $E14 + $D16;
            $E16 = $E15 + $D17;
            $E17 = $E16 + $D18;
            $E18 = $E17 + $D19;
            $E20 = $E18 + $D20;

            if ($no_of_stops_p < 5) {
                $o10 = $E4;
            } elseif ($no_of_stops_p == 5) {
                $o10 = $E5;
            } elseif ($no_of_stops_p == 6) {
                $o10 = $E6;
            } elseif ($no_of_stops_p == 7) {
                $o10 = $E7;
            } elseif ($no_of_stops_p == 8) {
                $o10 = $E8;
            } elseif ($no_of_stops_p == 9) {
                $o10 = $E9;
            } elseif ($no_of_stops_p == 10) {
                $o10 = $E10;
            } elseif ($no_of_stops_p == 11) {
                $o10 = $E11;
            } elseif ($no_of_stops_p == 12) {
                $o10 = $E12;
            } elseif ($no_of_stops_p == 13) {
                $o10 = $E13;
            } elseif ($no_of_stops_p == 14) {
                $o10 = $E14;
            } elseif ($no_of_stops_p == 15) {
                $o10 = $E15;
            } elseif ($no_of_stops_p == 16) {
                $o10 = $E16;
            } elseif ($no_of_stops_p == 17) {
                $o10 = $E17;
            } elseif ($no_of_stops_p == 18) {
                $o10 = $E18;
            } elseif ($no_of_stops_p == 19) {
                $o10 = $E18;
            } elseif ($no_of_stops_p == 20) {
                $o10 = $E20;
            } else {
                $o10 = 0;
            }

            $G6_p = 0;
            $G7_p = $F7;
            $G8_p = $F8;
            $G9_p = $F9 + $G8_p;
            $G10_p = $F10 + $G8_p;
            $G11_p = $F11 + $G10_p;
            $G12_p = $G11_p;
            $G13_p = $G12_p;
            $G14_p = $G13_p;
            $G15_p = $G14_p;
            $G16_p = $G15_p + $F16;
            $G17_p = $G16_p;
            $G18_p = $G17_p;
            $G19_p = $G18_p;
            $G20_p = $G19_p;
            $G21_p = $G20_p + $F21;
            $G22_p = $G21_p;
            $G23_p = $G22_p;
            $G24_p = $G23_p + $F24;
            $G25_p = $G24_p;
            $G26_p = $G25_p;
            $G27_p = $G26_p + $F27;
            $G28_p = $G27_p;
            $G29_p = $G28_p;
            $G30_p = $G29_p;

            if ($no_of_passenger < 7) {
                $o11 = $G6_p;
            }  elseif ($no_of_passenger == 7) {
                $o11 =  $G7_p;
            } elseif ($no_of_passenger == 8) {
                $o11 = $G8_p;
            } elseif ($no_of_passenger == 9) {
                $o11 =  $G9_p;
            } elseif ($no_of_passenger == 10) {
                $o11 =  $G10_p;
            } elseif ($no_of_passenger == 11) {
                $o11 =  $G11_p;
            } elseif ($no_of_passenger == 12) {
                $o11 =  $G12_p;
            } elseif ($no_of_passenger == 13) {
                $o11 =  $G13_p;
            } elseif ($no_of_passenger == 14) {
                $o11 =  $G14_p;
            } elseif ($no_of_passenger == 15) {
                $o11 =  $G15_p;
            } elseif ($no_of_passenger == 16) {
                $o11 =  $G16_p;
            } elseif ($no_of_passenger == 17) {
                $o11 =  $G17_p;
            } elseif ($no_of_passenger == 18) {
                $o11 =  $G18_p;
            } elseif ($no_of_passenger == 19) {
                $o11 =  $G19_p;
            } elseif ($no_of_passenger == 20) {
                $o11 =  $G20_p;
            } elseif ($no_of_passenger == 21) {
                $o11 =  $G21_p;
            } elseif ($no_of_passenger == 22) {
                $o11 =  $G22_p;
            } elseif ($no_of_passenger == 23) {
                $o11 =  $G23_p;
            } elseif ($no_of_passenger == 24) {
                $o11 =  $G24_p;
            } elseif ($no_of_passenger == 25) {
                $o11 =  $G25_p;
            } elseif ($no_of_passenger == 26) {
                $o11 =  $G26_p;
            } elseif ($no_of_passenger == 27) {
                $o11 =  $G27_p;
            } elseif ($no_of_passenger == 28) {
                $o11 = $G28_p;
            } elseif ($no_of_passenger == 29) {
                $o11 =  $G29_p;
            } elseif ($no_of_passenger == 30) {
                $o11 = $G30_p;
            } else {
                $o11 =  0;
            }

            $o12 = $base_price + $o10 + $o11;

            if ($area_of_installation_p == "<=100") {
                $o13 =  round($o12 * 1.5);
            } elseif ($area_of_installation_p == ">>100 & <=200") {
                $o13 =  round($o12 * 1.6);
            } elseif ($area_of_installation_p == ">>200 & <=300") {
                $o13 =  round($o12 * 1.8);
            } elseif ($area_of_installation_p == ">300") {
                $o13 =  round($o12 * 2);
            } else {
                $o13 = 0;
            }
            if ($area_of_installation_p == "blr") {
                $o14 = $o12 * 1.18;
            } else {
                $o14 = $o13 * 1.18;
            }

            if ($request->area_of_installation_p == 'blr') {
                $o39 = $o37 * 1.18;
            } else {
                $o39 = $o38 * 1.18;
            }

            if ($request->type_of_elevator_p == 'MR') {
                $o49 = $o39;
            } else {
                $o49 = $o14;
            }

            if ($no_of_passenger < 16) {
                $data['passenger_b_10'] = round($o49 * 1.1);
            } else if ($no_of_passenger > 15) {
                $data['passenger_b_10'] = round($o49 * 1.07);
            } else {
                $data['passenger_b_10'] = 0;
            }

            if ($no_of_passenger < 16) {
                $o54 = round($o49 * 1.1);
            } else if ($no_of_passenger > 15) {
                $o54 = round($o49 * 1.07);
            } else {
                $o54 = 0;
            }

            $o55 = round($o54 * 1.6);
            $o56 = round($o55 * 1.5);

            $data['passenger_b_9'] = round($data['passenger_b_10'] / 1.18);
            $data['passenger_b_11'] = round($data['passenger_b_10'] * 0.98);
            $data['passenger_b_14'] = round($o54 * 1.6);
            $data['passenger_b_13'] = round($data['passenger_b_14'] / 1.18);
            $data['passenger_b_15'] = round($data['passenger_b_14'] * 0.98);
            $data['passenger_b_18'] = $o56;
            $data['passenger_b_17'] = round($data['passenger_b_18'] / 1.18);
            $data['passenger_b_19'] = round($data['passenger_b_18'] * 0.98);
            $data['passenger_d_9'] = round($data['passenger_b_9'] * 2);
            $data['passenger_d_10'] = round($data['passenger_b_10'] * 2);
            $data['passenger_d_11'] = round($data['passenger_d_10'] * 0.975);
            $data['passenger_d_13'] = round($data['passenger_b_13'] * 2);
            $data['passenger_d_14'] = round($data['passenger_b_14'] * 2);
            $data['passenger_d_15'] = round($data['passenger_d_14'] * 0.975);
            $data['passenger_d_17'] = round($data['passenger_b_17'] * 2);
            $data['passenger_d_18'] = round($data['passenger_b_18'] * 2);
            $data['passenger_d_19'] = round($data['passenger_d_18'] * 0.975);
            $data['passenger_f_9'] = round($data['passenger_b_9'] * 3);
            $data['passenger_f_10'] = round($data['passenger_f_9'] * 1.18);
            $data['passenger_f_11'] = round($data['passenger_f_10'] * 0.97);
            $data['passenger_f_13'] = round($data['passenger_b_13'] * 3);
            $data['passenger_f_14'] = round($data['passenger_f_13'] * 1.18);
            $data['passenger_f_15'] = round($data['passenger_f_14'] * 0.97);
            $data['passenger_f_17'] = round($data['passenger_b_17'] * 3);
            $data['passenger_f_18'] = round($data['passenger_f_17'] * 1.18);
            $data['passenger_f_19'] = round($data['passenger_f_18'] * 0.97);
            $data['passenger_h_9'] = round($data['passenger_b_9'] * 5);
            $data['passenger_h_10'] = round($data['passenger_h_9'] * 1.18);
            $data['passenger_h_11'] = round($data['passenger_h_10'] * 0.965);
            $data['passenger_h_13'] = round($data['passenger_b_13'] * 5);
            $data['passenger_h_14'] = round($data['passenger_h_13'] * 1.18);
            $data['passenger_h_15'] = round($data['passenger_h_14'] * 0.965);
            $data['passenger_h_17'] = round($data['passenger_b_17'] * 5);
            $data['passenger_h_18'] = round($data['passenger_h_17'] * 1.18);
            $data['passenger_h_19'] = round($data['passenger_h_18'] * 0.97);

        } else {
            $capacity_in_kg = $request->capacity_in_kg_g;
            $type_of_elevator_g = $request->type_of_elevator_g;
            $area_of_installation_g = $request->area_of_installation_g;
            $no_of_stops_g = $request->no_of_stops_g;

            $e4 = 0; // from new working -goods
            $k2 = 0; // from new working -goods
            $G49 = $E49 + $F49;
            $K49 = $K48 + $D49;
            $M49 = $K49 + $L49;
            $Q49 = $Q48 + $D49;
            $S49 = $Q49 + $R49;
            $W49 = $W48 + $D49;
            $Y49 = $W49 + $X49;
            $j3 = $M49;
            $j2 = $G49;
            $j4= $S49;
            $j5= $Y49;
            $k3 = $j3 - $j2;
            $k4 = $j4 - $j2;
            $k5 = $j5 - $j2;
            $e5 = $D6;
            $e6 = $e5 + $D7;
            $e7 = $e6 + $D8;
            $e8 = $e7 + $D9;
            $e9 = $e8 + $D10;
            $e10 = $e9 + $D11;
            $e11 = $e10 + $D12;
            $e12 = $e11 + $D13;
            $e13 = $e12 + $D14;
            $e14 = $e13 + $D15;
            $e15 = $e14 + $D16;
            $e16 = $e15 + $D17;
            $e17 = $e16 + $D18;
            $e18 = $e17 + $D19;
            $e19 = $e18 + $D20;
            $e20 = $e19 + $D21;
            $e36 = 0;
            $e37 = $D28;
            $e38 = $D29 + $e37;
            $e39 = $e38 + $D74;
            $e40 = $e39 + $D75;
            $e41 = $e40 + $D76;
            $e42 = $e41 + $D77;
            $e43 = $e42 + $D78;
            $e44 = $e43 + $D79;
            $e45 = $e44 + $D80;
            $e46 = $e45 + $D81;
            $e47 = $e46 + $D82;
            $e48 = $e47 + $D83;
            $e49 = $e48 + $D84;
            $e50 = $e49 + $D85;
            $e51 = $e50 + $D86;
            $e52 = $e51 + $D87;

            if ($no_of_stops_g < 5) {
                $p35 = $e36;
            } elseif ($no_of_stops_g == 5) {
                $p35 = $e37;
            } elseif ($no_of_stops_g == 6) {
                $p35 = $e38;
            } elseif ($no_of_stops_g == 7) {
                $p35 = $e39;
            } elseif ($no_of_stops_g == 8) {
                $p35 = $e40;
            } elseif ($no_of_stops_g == 9) {
                $p35 = $e41;
            } elseif ($no_of_stops_g == 10) {
                $p35 = $e42;
            } elseif ($no_of_stops_g == 11) {
                $p35 = $e43;
            } elseif ($no_of_stops_g == 12) {
                $p35 = $e44;
            } elseif ($no_of_stops_g == 13) {
                $p35 = $e45;
            } elseif ($no_of_stops_g == 14) {
                $p35 = $e46;
            } elseif ($no_of_stops_g == 15) {
                $p35 = $e47;
            } elseif ($no_of_stops_g == 16) {
                $p35 = $e48;
            } elseif ($no_of_stops_g == 17) {
                $p35 = $e49;
            } elseif ($no_of_stops_g == 18) {
                $p35 = $e50;
            } elseif ($no_of_stops_g == 19) {
                $p35 = $e51;
            } elseif ($no_of_stops_g == 20) {
                $p35 = $e52;
            } else {
                $p35 = 0;
            }

            $p34 = $base_price;

            if ($capacity_in_kg == "500") {
                $p36 = $k2;
            } elseif ($capacity_in_kg == "1000") {
                $p36 = $k3;
            } elseif ($capacity_in_kg == "1500") {
                $p36 = $k4;
            } elseif ($capacity_in_kg == "2000") {
                $p36 = $k5;
            } else {
                $p36 = 0;
            }

            $p37 = $p34 + $p35 + $p36;

            if ($area_of_installation_g == "<=100") {
                $p38 =  round($p37 * 1.5);
            } elseif ($area_of_installation_g == ">>100 & <=200") {
                $p38 =  round($p37 * 1.6);
            } elseif ($area_of_installation_g == ">>200 & <=300") {
                $p38 =  round($p37 * 1.8);
            } elseif ($area_of_installation_g == ">300") {
                $p38 =  round($p37 * 2);
            } else {
                $p38 = 0;
            }

            if ($type_of_elevator_g == 'MR' && $area_of_installation_g == 'blr') {
                $p39 = $p37 * 1.18;
            } else {
                $p39 = $p38 * 1.18;
            }

            if ($no_of_stops_g < 5) {
                $p10 = $e4;
            } elseif ($no_of_stops_g == 5) {
                $p10 = $e5;
            } elseif ($no_of_stops_g == 6) {
                $p10 = $e6;
            } elseif ($no_of_stops_g == 7) {
                $p10 = $e7;
            } elseif ($no_of_stops_g == 8) {
                $p10 = $e8;
            } elseif ($no_of_stops_g == 9) {
                $p10 = $e9;
            } elseif ($no_of_stops_g == 10) {
                $p10 = $e10;
            } elseif ($no_of_stops_g == 11) {
                $p10 = $e11;
            } elseif ($no_of_stops_g == 12) {
                $p10 = $e12;
            } elseif ($no_of_stops_g == 13) {
                $p10 = $e13;
            } elseif ($no_of_stops_g == 14) {
                $p10 = $e14;
            } elseif ($no_of_stops_g == 15) {
                $p10 = $e15;
            } elseif ($no_of_stops_g == 16) {
                $p10 = $e16;
            } elseif ($no_of_stops_g == 17) {
                $p10 = $e17;
            } elseif ($no_of_stops_g == 18) {
                $p10 = $e18;
            } elseif ($no_of_stops_g == 19) {
                $p10 = $e19;
            } elseif ($no_of_stops_g == 20) {
                $p10 = $e20;
            } else {
                $p10 = 0;
            }

            if($capacity_in_kg == "500"){
                $p11 = $k2;
            } elseif($capacity_in_kg == "1000"){
                $p11 = $k3;
            } elseif($capacity_in_kg == "1500"){
                $p11 = $k4;
            } elseif($capacity_in_kg == "2000"){
                $p11 = $k5;
            } else {
                $p11 = 0;
            }

            $p12 = $base_price + $p10 + $p11;

            if ($area_of_installation_g == "<=100") {
                $p13 =  round($p12 * 1.5);
            } elseif ($area_of_installation_g == ">>100 & <=200") {
                $p13 =  round($p12 * 1.6);
            } elseif ($area_of_installation_g == ">>200 & <=300") {
                $p13 =  round($p12 * 1.8);
            } elseif ($area_of_installation_g == ">300") {
                $p13 =  round($p12 * 2);
            } else {
                $p13 = 0;
            }

            if (($type_of_elevator_g == 'MRL' && $area_of_installation_g == 'blr') || ($type_of_elevator_g == 'Hydraulic' && $area_of_installation_g == 'blr')) {
                $p14 = $p12 * 1.18;
            } else {
                $p14 = $p13 * 1.18;
            }

            if ($type_of_elevator_g == 'MR') {
                $p49 = $p39;
            } else {
                $p49 = $p14;
            }

            if ($capacity_in_kg == "500" || $capacity_in_kg == "1000") {
                $p54 = round($p49 * 1.1);
            } else {
                $p54 = round($p49 * 1.07);
            }

            if ($capacity_in_kg == "500" || $capacity_in_kg == "1000") {
                $data['goods_b_9'] = round($p49 * 1.1);
            } else {
                $data['goods_b_9'] = round($p49 * 1.07);
            }
            $p55 = round($p54 * 1.6);
            $data['goods_b_8'] = round($data['goods_b_9'] / 1.18) ?? 0;
            $data['goods_b_10'] = round($data['goods_b_9'] * 0.98) ?? 0;
            $data['goods_b_13'] = round($p54 * 1.6) ?? 0;
            $data['goods_b_12'] = round($data['goods_b_13'] / 1.18) ?? 0;
            $data['goods_b_14'] = round($data['goods_b_13'] * 0.98) ?? 0;
            $data['goods_b_17'] = round($p55 * 1.5) ?? 0;
            $data['goods_b_16'] = round($data['goods_b_17'] / 1.18) ?? 0;
            $data['goods_b_18'] = round($data['goods_b_17'] * 0.98) ?? 0;
            $data['goods_d_8'] = round($data['goods_b_8'] * 2) ?? 0;
            $data['goods_d_9'] = round($data['goods_d_8'] * 1.18) ?? 0;
            $data['goods_d_10'] = round($data['goods_d_9'] * 0.975) ?? 0;
            $data['goods_d_12'] = round($data['goods_b_12'] * 2) ?? 0;
            $data['goods_d_13'] = round($data['goods_d_12'] * 1.18) ?? 0;
            $data['goods_d_14'] = round($data['goods_d_13'] * 0.975) ?? 0;
            $data['goods_d_16'] = round($data['goods_b_16'] * 2) ?? 0;
            $data['goods_d_17'] = round($data['goods_d_16'] * 1.18) ?? 0;
            $data['goods_d_18'] = round($data['goods_d_17'] * 0.975) ?? 0;
            $data['goods_f_8'] = round($data['goods_b_8'] * 3) ?? 0;
            $data['goods_f_9'] = round($data['goods_f_8'] * 1.18) ?? 0;
            $data['goods_f_10'] = round($data['goods_f_9'] * 0.965) ?? 0;
            $data['goods_f_12'] = round($data['goods_b_12'] * 3) ?? 0;
            $data['goods_f_13'] = round($data['goods_f_12'] * 1.18) ?? 0;
            $data['goods_f_14'] = round($data['goods_f_13'] * 0.965) ?? 0;
            $data['goods_f_16'] = round($data['goods_b_16'] * 3) ?? 0;
            $data['goods_f_17'] = round($data['goods_f_16'] * 1.18) ?? 0;
            $data['goods_f_18'] = round($data['goods_f_17'] * 0.965) ?? 0;
            $data['goods_h_8'] = round($data['goods_b_8'] * 5) ?? 0;
            $data['goods_h_9'] = round($data['goods_h_8'] * 1.18) ?? 0;
            $data['goods_h_10'] = round($data['goods_h_9'] * 0.96) ?? 0;
            $data['goods_h_12'] = round($data['goods_b_12'] * 5) ?? 0;
            $data['goods_h_13'] = round($data['goods_h_12'] * 1.18) ?? 0;
            $data['goods_h_14'] = round($data['goods_h_13'] * 0.96) ?? 0;
            $data['goods_h_16'] = round($data['goods_b_16'] * 5) ?? 0;
            $data['goods_h_17'] = round($data['goods_h_16'] * 1.18) ?? 0;
            $data['goods_h_18'] = round($data['goods_h_17'] * 0.96) ?? 0;

            $data['passenger_b_10'] =  $data['goods_b_9'];
            $data['passenger_b_9']  = $data['goods_b_8'];
            $data['passenger_b_11'] = $data['goods_b_10'];
            $data['passenger_b_14'] = $data['goods_b_13'];
            $data['passenger_b_13'] = $data['goods_b_12'];
            $data['passenger_b_15'] = $data['goods_b_14'];
            $data['passenger_b_18'] = $data['goods_b_17'];
            $data['passenger_b_17'] = $data['goods_b_16'];
            $data['passenger_b_19'] = $data['goods_b_18'];
            $data['passenger_d_9']  = $data['goods_d_8'] ;
            $data['passenger_d_10'] = $data['goods_d_9'] ;
            $data['passenger_d_11'] = $data['goods_d_10'];
            $data['passenger_d_13'] = $data['goods_d_12'];
            $data['passenger_d_14'] = $data['goods_d_13'];
            $data['passenger_d_15'] = $data['goods_d_14'];
            $data['passenger_d_17'] = $data['goods_d_16'];
            $data['passenger_d_18'] = $data['goods_d_17'];
            $data['passenger_d_19'] = $data['goods_d_18'];
            $data['passenger_f_9']  = $data['goods_f_8'] ;
            $data['passenger_f_10'] = $data['goods_f_9'] ;
            $data['passenger_f_11'] = $data['goods_f_10'];
            $data['passenger_f_13'] = $data['goods_f_12'];
            $data['passenger_f_14'] = $data['goods_f_13'];
            $data['passenger_f_15'] = $data['goods_f_14'];
            $data['passenger_f_17'] = $data['goods_f_16'];
            $data['passenger_f_18'] = $data['goods_f_17'];
            $data['passenger_f_19'] = $data['goods_f_18'];
            $data['passenger_h_9']  = $data['goods_h_8'] ;
            $data['passenger_h_10'] = $data['goods_h_9'] ;
            $data['passenger_h_11'] = $data['goods_h_10'];
            $data['passenger_h_13'] = $data['goods_h_12'];
            $data['passenger_h_14'] = $data['goods_h_13'];
            $data['passenger_h_15'] = $data['goods_h_14'];
            $data['passenger_h_17'] = $data['goods_h_16'];
            $data['passenger_h_18'] = $data['goods_h_17'];
            $data['passenger_h_19'] = $data['goods_h_18'];
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        return $request;
    }

}
