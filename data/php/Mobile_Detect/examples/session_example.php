<?php
	session_start();
	require_once '../Mobile_Detect.php';
	function layoutTypes() { return array('classic', 'mobile', 'tablet'); }
	function initLayoutType() {
		if (!class_exists('Mobile_Detect')) { return 'classic'; }
		$detect = new Mobile_Detect;
		$isMobile = $detect->isMobile();
		$isTablet = $detect->isTablet();
		$layoutTypes = layoutTypes();
		if ( isset($_GET['layoutType']) ) { $layoutType = $_GET['layoutType']; }
		else { if (empty($_SESSION['layoutType'])) { $layoutType = ($isMobile ? ($isTablet ? 'tablet' : 'mobile') : 'classic'); } else { $layoutType =  $_SESSION['layoutType']; } }
		if ( !in_array($layoutType, $layoutTypes) ) { $layoutType = 'classic'; }
		$_SESSION['layoutType'] = $layoutType;
		return $layoutType;
	}
	$layoutType = initLayoutType();
?>
<?php if(!isset($_GET['page'])): ?>
    <h1>Demo page number one.</h1>
    <p>You can go to page <a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=two">two</a>.</p>
    <p>Showing you the <b><?php echo $layoutType; ?></b> version.</p>
    <p><b>Note:</b> When running this test using the same browser with multiple User-Agents, clear your cookies/session before each test.</p>
<?php endif; ?>
<?php if(isset($_GET['page']) && $_GET['page']=='two'): ?>
    <h1>Demo page number two.</h1>
    <p>You can go back to page <a href="<?php echo $_SERVER['PHP_SELF']; ?>">one</a>.</p>
    <p>Showing you the <b><?php echo $layoutType; ?></b> version.</p>
<?php endif; ?>
<?php foreach(layoutTypes() as $_layoutType): ?>
    <?php if($_layoutType == $layoutType): ?>
        <?php echo strtoupper($_layoutType); ?>
    <?php else: ?>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?layoutType=<?php echo $_layoutType; ?>"><?php echo strtoupper($_layoutType); ?></a>
    <?php endif; ?>
<?php endforeach;