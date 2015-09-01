<div id="paid" align="center" style="background-color: black; height: 350px; ">
  
  <div style="padding-top: 100px; font-size:18px; color:red;" ><b>This is a paid channel,You have to pay amount to watch this</b><br><br>
    <input style="text-align:center; width:80px;" readonly type= "text" name="amt" value="$<?php echo $amount ;?>">
  </div>

  <div>				
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick-subscriptions" />
    <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
    <input type="hidden" name="item_name" value="<?php echo $channel_name;?>">
    <input type="hidden" name="item_number" value="<?php echo $post_id;?>">
    <input type="hidden" name="lc" value="GB">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="src" value="1">
    <input type="hidden" name="a3" value="<?php echo $amount; ?>">
    <input type="hidden" name="p3" value="1">
    <input type="hidden" name="t3" value="M">
    <input type="hidden" name="no_shipping" value="0" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="mrb" value="3FWGC6LFTMTUG" />
    <input type="hidden" name="bn" value="IC_Sample" />
    <input type="hidden" name="currency_code" value="<?php echo $currency;?>">
    <input type="hidden" name="return" value="<?php echo get_post_permalink();?>" />
    <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">
    <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
    <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>

</div>