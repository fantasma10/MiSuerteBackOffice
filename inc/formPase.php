
<form method="post" id="formPase">
    <input type="hidden" id="hParametrosX" name="hParametrosX" value="<?php echo isset($_POST['hParametrosX'])?$_POST['hParametrosX']:""; ?>"/>  
    
    
    <input type="hidden" id="hidCadenaX" name="hidCadenaX" value="<?php echo isset($_POST['hidCadenaX'])?$_POST['hidCadenaX']:-1; ?>" />
    <input type="hidden" id="hidSubCadenaX" name="hidSubCadenaX" value="<?php echo isset($_POST['hidSubCadenaX'])?$_POST['hidSubCadenaX']:-1; ?>"/>
    <input type="hidden" id="hidCorresponsalX" name="hidCorresponsalX" value="<?php echo isset($_POST['hidCorresponsalX'])?$_POST['hidCorresponsalX']:-1; ?>"/>
    <input type="hidden" id="hidVersionX" name="hidVersionX" value="<?php echo isset($_POST['hidVersionX'])?$_POST['hidVersionX']:-1; ?>" />
    <input type="hidden" id="hidTipoMovX" name="hidTipoMovX" value="<?php echo isset($_POST['hidTipoMovX'])?$_POST['hidTipoMovX']:-1; ?>" />
    
    <input type="hidden" id="hnumCtaX" name="hnumCtaX" value="<?php echo isset($_POST['hnumCtaX'])?$_POST['hnumCtaX']:''; ?>"/>
    
    <input type="hidden" id="hnumContratoX" name="hnumContratoX" value="<?php echo isset($_POST['hnumContratoX'])?$_POST['hnumContratoX']:''; ?>"/>
    
    <input type="hidden" id="hidRepLegX" name="hidRepLegX" value="<?php echo isset($_POST['hidRepLegX'])?$_POST['hidRepLegX']:''; ?>"/>
    
    <!-- estos son para las fechas solo ai que descomentar >
    <input type="hidden" id="hHoyX" name="hHoyX" value="<?php echo isset($_POST['hHoyX'])?$_POST['hHoyX']:strftime( "%Y-%m-%d", time()); ?>" />
    <input type="hidden" id="hHaceUnMesX" name="hHaceUnMesX" value="<?php echo isset($_POST['hHaceUnMesX'])?$_POST['hHaceUnMesX']:date('Y-m-d', strtotime('-1 month')); ?>" />
    <input type="hidden" id="hHaceUnaSemX" name="hHaceUnaSemX" value="<?php echo isset($_POST['hHaceUnaSemX'])?$_POST['hHaceUnaSemX']:date('Y-m-d', strtotime('-1 week')); ?>" /-->
    
    <input type="hidden" id="hRutaX" name="hRutaX" value="<?php echo isset($_POST['hRutaX'])?$_POST['hRutaX']:""; ?>"/>
</form>  


