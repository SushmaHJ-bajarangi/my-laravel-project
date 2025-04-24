
<html>
<head>
    <style>
        .a4-page {
            width: 210mm;
            height: 297mm;
            /*margin: 20px auto;*/
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            background-color: #ffffff;
            border: 1px solid #ddd;
            /*display: flex;*/
            /*align-items: flex-start;*/
            /*flex-direction: column;*/
        }

        .a4-page-inner {
            width: calc(100% - 4cm);
            height: calc(100% - 4cm);
            /*padding: 2cm;*/
            box-sizing: border-box;
            background-color: #ffffff;
            border: 1px solid black;

            margin-top: 30mm;
            margin-left: 20mm;
            margin-right: 20mm;
            margin-bottom: 20mm;

            font-size: 13px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Times New Roman', serif;
            position: relative;
        }

        table {
            border-collapse: collapse;
            width:99%;
            height:20%;
            font-size: 13px;
        }

        table td {
            border: 1px solid black;
        }

        .left-text {
            text-align: right;
            position: absolute;
            margin-bottom: 20mm;
            font-size: 13px;
            margin-left: 30mm;
        }

        .head-text {
            margin-top: 5mm; /* 1cm = 10mm */
            margin-left:40mm;
            /*width: 100%;*/
            position: absolute;
            top: 10mm;
            text-align: center;
        }

        .head-img{
            position: absolute;
            margin-left:130mm;
            margin-top: 1mm;

        }
        .sign-img{
            position: absolute;
            margin-left:1mm;
        }

        h1, p {
            margin: 0 0 10px;
        }
    </style>
</head>
<body>
<div class="a4-page">


    <div class="head-img">
        <img src="{{asset('images/preloder.gif')}}" width="200px" height="100px" alt="logo" />
    </div>


    <div class="head-text">
        <h5><u>OFFER FOR ANNUAL MAINTENANCE CONTRACT FOR ELEVATOR</u></h5>
    </div>

    <div class="a4-page-inner">
        <p style="margin-left:1mm;"><strong><b>Offer Generated Date</b> : 3/2/2025</strong> <span style="margin-left: 200px;"> <b>Offer No.</b>: Feb'25-006-TKE-SR-2758/W </span> <br>
            <b>Site Name</b> : Ms. Jayasheela & Ms. Vanishree <br>
            <b>Address</b> :  No. 13, 1st Main, Tata Silk Farm, Basavanagudi, Bangalore - 560004.<br>
            <b>Subject</b> :  Expiry of Warranty for the elevator <br>
            <b>To,</b><br>
            <b>Ms. Jayasheela & Ms. Vanishree.</b> <br><br>
            Warranty period of your elevator installed at your site Ms. Jayasheela & Ms. Vanishree will expire on
            8/3/2025. In order to get uninterrupted service and for the passenger safety, as per Karnataka Lift Act it is
            mandatory to sign up the annual maintenance contract with registered elevator company for servicing of your
            elevator. Inspection charges and one time repairing charges shall be applicable as required for your elevator
            prior to signup of the AMC with us.
            <br><br>
            We shall not be liable for any breakdown, fault or any mishap which occurs for your above elevator after the
            above mentioned expiry date, unless the Annual Maintenance Contract is signed up with us on or before the
            expiry date.
            <br><br>
            We have following three types of Annual Maintenance Contracts. You are requested to kindly choose any of
            the following annual maintenance contracts. Please note that only down gradation of plan is possible after
            you have entered into AMC with us</p>

        <table style="margin-left:1mm;">
            <tr>
                <td><b>Name of The package</b></td>
                <td><b>Inclusions</b></td>
                <td><b>Technical Specifications</b></td>
                <td><b>Annual Charges per Elevator in INR</b></td>
                <td><b>Total @ 18% GST per Elevator in INR</b></td>

            </tr>
            <tr>
                <td><b>Silver Care </b> </td>
                <td> Preventive Maintenance Service & Breakdowns are only covered
                    under this contract. Any spares are to be charged extra. </td>
                <td rowspan="3">6 Passengers, 408 kgs., G+5, 6 Stops, Optima MRL.</td>
                <td>29,700/- </td>
                <td>35,046/- </td>
            </tr>
            <tr>
                <td><b>Gold Care</b></td>
                <td>Elevator spares like Rope, 3VF Drive for Machine, Controller, Motherboard, Machine, Door
                    Drive, Door Sensor, Contactors, Light and Batteries are not covered under this contract.  </td>
                <td>47,520/- </td>
                <td>56,074/- </td>
            </tr>

            <tr>
                <td><b>Platinum Care</b></td>
                <td>All Elevator spares excluding (Batteries and Lights) are covered under this contract. </td>
                <td>71,280/-</td>
                <td>84,111/-</td>
            </tr>

            <tr>
                <td colspan="5"><b>***Note :Any accidental damages, physical damages or tempering by unauthorized person are not covered
                        under any of  the above mentioned packages.</b></td>
            </tr>

        </table>

        <p style="margin-left:1mm;">If you wish to avail 24/7 service or breakdown facility for the elevator, you would be required to make an additional
            payment of INR 34,920 inclusive of GST for availing an additional 24/7 Diamond Care.
            <br><br>
            For any assistance regarding the renewal of service period, you are requested to please contact our office or call at
            our office so that our representative can contact you for assistance. Our contact telephone number is: Toll Free -
            1800 200 4990 / Tolled: 080 - 41253500; 41483500
            <br><br>
            Yours Faithfully,
            <br>
            For <b>TEKNIX ELEVATORS PVT.LTD.</b>

        <div class="sign-img">
            <img src="{{asset('images/signloho.png')}}" width="200px" height="50px" alt="logo" />
        </div>
        <br> <br> <br>
        <b>AUTHORISED OFFICIALS</b>

        </p>
    </div>
    <br>

    <div class="left-text">TEKNIX ELEVATORS PVT. LTD.<br>
        No. 3354/210, Banashankiri 2nd Stage, Bangalore-560070.<br>
        <a href="https://www.teknixelevators.com/"> www.teknixelevators.com </a>
        I info@teknixelevators.com I Toll Free No. 1800-200-4990 I +91 80 41253500
    </div>

</div>

</body>
</html>

