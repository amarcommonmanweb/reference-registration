
<style>

#main_content{
    font-size:17px;
    width:500px;
    border:1px solid #cccccc;
    padding:10px;
}

#end_part{
    float:left;
}
</style>

<center>
    <div id="main_content">
        <div id="title">Hi, <?php echo $firstname; ?></div>
        
        <p>
            Thank you for registering with Crossbow.
            <br/><br/>
            Click on the link below to activate your account and access the Crossbow Services
            <br/><br/>
            <?php echo $url_string; ?>
        </p>
        
        <div id="end_part">
            Best Regards,
            <br/>
            Crossbow Team
        </div>
        <div style="clear:both"></div>
    </div>
    
</center>
