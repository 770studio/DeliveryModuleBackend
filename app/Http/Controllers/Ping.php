<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class Ping extends Controller
{
  function checkin(Request $request ) {
/*
      1. obtain location update from  driver
      2. response with the current status and "basic config"
      3. what driver needs to know is:
            - either he is registered or not. if he is not , he shd not be shown the buttons, he might be shown a text that he is not on the list
            - if he is assigned an order or not
            - current order status and next order status. button text is next order status
            - if he is allowed to reject order on the current stage
            - order details: order id, customer name , address, location, etc...
              order details is shown by button press

*/

      dd(66655555555, $request, $request->d);
  }
}
