
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
            Your new Credentials are <br/><br/>
            Username: <?php echo $username; ?><br/>
            Password: <?php echo $password; ?>
        </p>
        
        <div id="end_part">
            Best Regards,
            <br/>
            Crossbow Team
        </div>
        <div style="clear:both"></div>
    </div>
    
</center>
