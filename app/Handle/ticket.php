﻿

<div style="height : 300px">
    <div style="margin-top: 10px; height: 130px; background-color: #F5F7F9; border-radius: 15px; display: flex;">
        <div style="flex: 3; height: 100%; display: flex; border-right: 2px dashed #808080; position: relative;">
            <div style="background-color: #fff; height: 120px; margin: 5px; border-radius: 15px; display: flex; justify-content: center; align-items: center;">
                <div style="height: 100%; display: flex; justify-content: center; align-items: center;">
                    <img src="https://www.vietjetair.com/static/media/vj-logo.0f71c68b.svg" style="object-fit: contain; width: 80%;">
                </div>
            </div>
            <div style="display: flex; margin-left: 30px; padding: 10px; justify-content: space-between; align-items: center; padding-right: 30px; flex: 1;">
                <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <p style="margin: 0; margin-top: 10px; font-size: 14px; color: #808080; font-family: Inter;">Depart</p>
                    <h5 style="margin-top: 5px; font-family: Inter;">{{departuretime}}</h5>
                    <p style="margin: 0; font-size: 12px; color: #808080;">{{departureday}}</p>
                </div>
                <div style="display: flex; justify-content: space-around; align-items: center; flex: 1;">
                    <span style="display: block; width: 10px; height: 10px; background-color: #73B5FF; border-radius: 50%; position: relative;"></span>
                    <div style="padding: 5px 15px; background-color: #DCEDFE; border-radius: 15px; font-size: 13px; font-family: Inter; position: relative; z-index: 10; color: #73B5FF; font-weight: 500;">
                        {{duration}}
                    </div>
                    <span style="display: block; width: 10px; height: 10px; background-color: #73B5FF; border-radius: 50%; position: relative;"></span>
                </div>
                <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <p style="margin: 0; margin-top: 10px; font-size: 14px; color: #808080; font-family: Inter;">Arrive</p>
                    <h5 style="margin-top: 5px; font-family: Inter;">{{arrivaltime}}</h5>
                    <p style="margin: 0; font-size: 12px; color: #808080;">{{arrivalday}}</p>
                </div>
            </div>
        </div>
        <div style="flex: 1; padding: 10px;">
            <p style="margin-top: 20px; margin-bottom: 2px; font-weight: 500; font-size: 14px; color: #808080; font-family: Inter; text-align: center;">Price</p>
            <div style="display: flex; justify-content: center; align-items: center;">
                <p style="font-size: 20px; font-family: Inter; font-weight: bold; margin: 0;">{{originalprice}}</p>
                <p style="margin-left: 8px;">VND</p>
            </div>
        </div>
    </div>
    <div style="font-family: Arial, sans-serif;">
        <h2>Customer Information</h2>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr style="background-color: #e01a59;">
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;color : #fff">Field</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;color : #fff">Value</th>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Customer Name</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{customername}}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Customer Identify</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{customeridentify}}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Seat ID</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{seatid}}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Flight ID</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{flightid}}</td>
            </tr>

            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">Customer Phone</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{customerphone}}</td>
            </tr>
        </table>

    </div>


</div>