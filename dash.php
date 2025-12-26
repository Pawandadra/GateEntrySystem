<?php
	include "./process/operations/main.php";
	include "./process/operations/stats.php";
	$title = "Gate Register";
	$acc_code = "U02";
	if(!isset($_SESSION['id']) && empty($_SESSION['id'])) {
   header("location:login.php");
	}
	require "./functions/access.php";
	require_once "./template/header.php";
	require "functions/dbfunc.php";

  $loc = $_SESSION['loc'];

  $new_arrivals = false;
  $quote = false;
  $clock = false;
  $banner = false;

  $banner = $_SESSION["banner"];
  $activedash = $_SESSION["activedash"];

  if($banner == "true"){
  	$banner = true;
  }elseif($banner == "false"){
  	$banner = false;
  }

  if($activedash == 'clock'){
  	$clock = true;
  }elseif($activedash == 'quote'){
  	$quote = true;
  }elseif($activedash == 'newarrivals'){
  	$new_arrivals = true;
  }else{
  	$new_arrivals = false;
	  $quote = false;
	  $clock = false;
  }

	$data = checknews($conn, $loc);
	if($data){
		$news = true;
		$new_arrivals = false;
	  $quote = false;
	  $clock = false;
	  $banner = false;
	}else{
		$news = false;
	}

 $img_flag = true;
	if(!$e_img){
		$img_flag = false;
	}

	$jsonfile = file_get_contents("assets/quotes.json");
  $quotes = json_decode($jsonfile, true);
  $onequote = $quotes[rand(0, count($quotes) - 1)];
?>

<link rel="stylesheet" href="assets/css/mobile.css">
<body style="background-color: #F1EADE;"> 
<!-- MAIN CONTENT START -->
<div class="content" style="min-height: calc(100vh - 90px);">
	<div class="container-fluid">
	  <div class="row">
	    <div class="col-md-6">
	    	<div class="card" style="min-height: calc(100vh - 150px);">
	        <div class="card-body">
	        	<?php if($banner) { ?>
							<img class="img-responsive" src="assets/img/banner.png">
						<?php }else{ ?>
							<h3 class="text-center"><?php echo $_SESSION['lib']; ?></h3>
	        	<?php } ?>
	        <?php if($news) { ?>
	        	<div class="card-block">
							<div class="card-title text-info h4 text-center">
								 <?php echo "<br/>".$data['nhead']; ?> 
							</div>		        
							<div class="h4 text-center" style="text-align: justify !important;">
								 <?php echo "<br/>".nl2br($data['nbody']); ?> 
							</div>
							<div class="h4 text-success text-center">
						 		<?php echo "<br/>".$data['nfoot']; ?> 
							</div>
						</div>
					<?php } ?>
					<?php if($new_arrivals) { ?>
						<h3 class="text-center">New Arrivals</h3>
						<div class="new-arrivals">
							<img src="assets/books/1.png">
							<img src="assets/books/2.png">
							<img src="assets/books/3.png">
							<img src="assets/books/4.png">
						</div>
						<div class="new-arrivals">
							<img src="assets/books/5.png">
							<img src="assets/books/6.png"> 
							<img src="assets/books/7.png">
							<img src="assets/books/8.png">
						</div>
					<?php } ?>
					<?php if($quote) { ?>
						<div class="card-block2" style="min-height: calc(100vh - 430px);">
							<div class="qcard">
							  <div class="qcontent">
							    <h3 class="qsub-heading">Quote for the thought</h3>
							    <blockquote>
								    <h1 class="qheading"><?php echo $onequote["content"]; ?></h1>
								    <p class="qcaption"><strong><?php echo $onequote["author"]; ?></strong></p>
							  	</blockquote>
							  </div>
							</div>
						</div>
					<?php } ?>
					<?php if($clock) { ?>
						<div class="card-body">
							<div class="analogclock">
							  <div>
							    <div class="cinfo cdate"></div>
							    <div class="cinfo cday"></div>
							  </div>
							  <div class="cdot"></div>
							  <div>
							    <div class="chour-hand"></div>
							    <div class="cminute-hand"></div>
							    <div class="csecond-hand"></div>
							  </div>
							  <div id="dial">
							    <span class="n3">3</span>
							    <span class="n6">6</span>
							    <span class="n9">9</span>
							    <span class="n12">12</span>
							  </div>
							  <div class="cdiallines"></div>
							</div>
						</div>
					<?php } ?>
	        </div>
	      </div>
	    </div>
	    <div class="col-md-6 text-center" style="margin-top: 24px;">
	    	<div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
          <h2 style="flex-grow: 1; text-align: center;">In Out Management System</h2>
          <a class="nav-link" href="functions/signout.php" style="display: flex; align-items: center; text-decoration: none;">
            <i class="material-icons">power_settings_new</i>
            <p class="d-lg-none d-md-block" style="margin: 0; padding-left: 5px;">Logout</p>
          </a>
        </div>
      <h3><?php echo $_SESSION['locname']; ?></h3>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <input type="text" name="id" id="usn" class="" value="" autofocus="true">
      </form>
	    	<?php
	    		if(isset($d_status)){
	    	?>
	    	<div class="card-body text-center">
	    		<?php if($img_flag) { ?>
	    			<img src="data:image/jpg/png/jpeg;base64,<?php echo base64_encode($e_img); ?>"  class="rounded-circle mb-4" alt="...">
		    	<?php } else { ?>
		    		<img src="assets/img/placeholder.png" class="rounded-circle mb-4" alt="...">
		    	<?php } ?>
					<h4 class="mb-0" style="font-weight: 800;"><?php echo $e_name; ?></h4>
					<p class="mb-2"><?php echo $usn; ?></p>
				</div>
				<?php
					}
				?>
		    <div class="h1 t-shadow">
					<?php
						if ($d_status == "OUT") {
						    echo "<span class='status-inout text-danger animated flash'>OUT</span>";
						} elseif ($d_status == "IN") {
						    echo "<span class='status-inout text-success animated flash'>IN</span>";
						}
					?>
				</div>
				<div class="h2 t-shadow">
					<?php
						if ($msg == "1") {
							?> <span class="animated flash"> <?php 
						    echo "<span class='text-primary'>Your ".$_SESSION['noname']." is: " . $usn . "<br>Entry time is: " . date('g:i A', strtotime($time))."</span>";
						    ?> </span> <?php
						} elseif ($msg == "2") {
						    # code...
						    ?> <span class="animated flash"> <?php 
						    echo "<span class='text-warning'>You just Checked In.<br> Wait for 10 Seconds to Check Out.</span>";
						    ?> </span> <?php
						} elseif ($msg == "3") {
						    # code...
						    ?> <span class="animated flash"> <?php 
						    echo "<span class='text-danger'>Invalid or Expired ".$_SESSION['noname']."<br> Contact Librarian for more details.</span>";
						    ?> </span> <?php
						} elseif ($msg == "4") {
						    # code...
						    ?> <span class="animated flash"> <?php 
						    echo "<span class='text-success'>Your Exit time is: " . date('g:i A', strtotime($time)) . "<br><span class='text-warning'>Total Time Duration : ".$otime[0]."</span>";
						    ?> </span> <?php
						} elseif ($msg == "5") {
						    # code...
						    ?> <span class="animated flash"> <?php 
						    echo "<span class='text-info'>You just Checked Out.<br> Wait for 10 Seconds to Check In.</span>";
						    ?> </span> <?php
						} else { ?> 
							<div class="text-center mt-3">
							    <button id="cameraBtn" class="btn btn-primary btn-lg" onclick="openCamera()">
							      <i class="material-icons">camera_alt</i> Scan with Phone Camera
							    </button>
							  </div>
							  <div id="cameraDiv" style="display: none;">
							    <div id="scanner" style="width: 100%; height: 300px;"></div>
							    <div id="scanStatus" class="text-center mt-2">
							      <span class="badge badge-warning">Loading camera...</span>
							    </div>
							    <button onclick="stopCamera()" class="btn btn-danger mt-2">Stop Camera</button>
							  </div>							  <div class="text-center mt-3">

							  </div>
							  <div id="cameraContainer" style="display: none;">
							    <video id="cameraPreview" width="100%" height="300" autoplay></video>
							    <canvas id="canvas" style="display: none;"></canvas>
							    <div class="text-center mt-2">
							      <button id="stopCamera" class="btn btn-danger">Stop Camera</button>
							    </div>
							  </div>
							<div class="idle">
								<div class="animated pulse infinite"> 
							    <span class='text-info'>SCAN YOUR ID CARD</span>
							  </div>
							  <div class="row">
									<div class="col-md-3">
				            <div class="card card-stats">
				              <div class="card-header card-header-info card-header-icon">
				                <div class="card-icon">
				                </div>
				                <p class="card-category">Gentlemen</p>
				                <h3 class="card-title"><?php echo $male[0]; ?></h3>
				              </div>
				              <div class="card-footer">
				                <div class="stats">
				                  <i class="material-icons">update</i> Just Updated
				                </div>
				              </div>
				            </div>
				          </div>
				          <div class="col-md-3">
				            <div class="card card-stats">
				              <div class="card-header card-header-rose card-header-icon">
				                <div class="card-icon">
				                </div>
				                <p class="card-category">Ladies</p>
				                <h3 class="card-title"><?php echo $female[0]; ?></h3>
				              </div>
				              <div class="card-footer">
				                <div class="stats">
				                  <i class="material-icons">update</i> Just Updated
				                </div>
				              </div>
				            </div>
				          </div>
				          <div class="col-md-3">
				            <div class="card card-stats">
				              <div class="card-header card-header-success card-header-icon">
				                <div class="card-icon">
				                </div>
				                <p class="card-category">Checked In</p>
				                <h3 class="card-title"><?php echo $tin[0]; ?></h3>
				              </div>
				              <div class="card-footer">
				                <div class="stats">
				                  <i class="material-icons">update</i> Just Updated
				                </div>
				              </div>
				            </div>
				          </div>
				          <div class="col-md-3">
				            <div class="card card-stats">
				              <div class="card-header card-header-warning card-header-icon">
				                <div class="card-icon">
				                </div>
				                <p class="card-category">Day Count</p>
				                <h3 class="card-title"><?php echo $visit[0]; ?></h3>
				              </div>
				              <div class="card-footer">
				                <div class="stats">
				                  <i class="material-icons">update</i> Just Updated
				                </div>
				              </div>
				            </div>
				          </div>
								</div>
							</div>
					<?php
						}
					?>
				</div>
	    </div>
	  </div>              
	</div>
</div>

<!--  editing started by Devansh Gupta-->
<script src="assets/js/analogclock.js"></script>
<script src="https://unpkg.com/@zxing/library@latest/umd/index.min.js"></script>
<script>
let scanning = false;
let codeReader = null;
let currentStream = null;

function openCamera() {
    const cameraDiv = document.getElementById('cameraDiv');
    cameraDiv.style.display = 'block';

    document.getElementById('scanStatus').innerHTML =
        '<span class="badge badge-warning">Starting camera...</span>';

    startScanner();
}

function startScanner() {
    const scannerDiv = document.getElementById('scanner');

    // Clear previous content
    scannerDiv.innerHTML = '';

    // Create video element
    const video = document.createElement('video');
    video.id = 'barcodeVideo';
    video.style.width = '100%';
    video.style.height = '100%';
    video.style.objectFit = 'cover';
    scannerDiv.appendChild(video);

    // Initialize scanner
    codeReader = new ZXing.BrowserMultiFormatReader();

    // Get available cameras
    codeReader.listVideoInputDevices()
        .then(videoInputDevices => {
            let deviceId = null;

            // Try to find back camera
            for (const device of videoInputDevices) {
                if (device.label.toLowerCase().includes('back') ||
                    device.label.toLowerCase().includes('rear')) {
                    deviceId = device.deviceId;
                    break;
                }
            }

            // If no back camera, use first available
            if (!deviceId && videoInputDevices.length > 0) {
                deviceId = videoInputDevices[0].deviceId;
            }

            document.getElementById('scanStatus').innerHTML =
                '<span class="badge badge-success">Scanning... Point at barcode</span>' +
                '<button onclick="toggleTorch()" class="btn btn-sm btn-outline-warning ml-2">' +
                '🔦 Flash</button>';

            // Start scanning
            return codeReader.decodeFromVideoDevice(
                deviceId,
                'barcodeVideo',
                (result, err) => {
                    if (result) {
                        handleScanResult(result.text);
                    }
                }
            );
        })
        .then(() => {
            scanning = true;

            // Get the video stream for torch control
            const video = document.getElementById('barcodeVideo');
            if (video.srcObject) {
                currentStream = video.srcObject;
                optimizeForLowLight(video.srcObject);
            }
        })
        .catch(err => {
            console.error('Scanner error:', err);
            document.getElementById('scanStatus').innerHTML =
                '<span class="badge badge-danger">Error: ' + err.message + '</span>';
        });
}

function optimizeForLowLight(stream) {
    // Try to optimize camera for low light
    if (stream && stream.getVideoTracks().length > 0) {
        const videoTrack = stream.getVideoTracks()[0];

        try {
            // Apply constraints for better low-light performance
            videoTrack.applyConstraints({
                advanced: [
                    { exposureMode: 'continuous' },
                    { focusMode: 'continuous' },
                    { whiteBalanceMode: 'continuous' },
                    { brightness: { ideal: 0.7 } },
                    { contrast: { ideal: 0.7 } }
                ]
            });
        } catch (e) {
            console.log("Could not optimize camera settings:", e);
        }
    }
}

function toggleTorch() {
    if (!currentStream) return;

    const videoTrack = currentStream.getVideoTracks()[0];
    if (videoTrack && videoTrack.getCapabilities) {
        const capabilities = videoTrack.getCapabilities();

        if (capabilities.torch) {
            const torchState = videoTrack.getSettings().torch || false;

            videoTrack.applyConstraints({
                advanced: [{ torch: !torchState }]
            }).then(() => {
                const btn = document.querySelector('#scanStatus .btn-outline-warning');
                if (btn) {
                    btn.innerHTML = !torchState ? '🔦 On' : '🔦 Flash';
                    btn.className = !torchState ?
                        'btn btn-sm btn-warning ml-2' :
                        'btn btn-sm btn-outline-warning ml-2';
                }
            }).catch(err => {
                console.log("Torch not supported:", err);
            });
        } else {
            alert("Flashlight not supported on this device");
        }
    }
}

function handleScanResult(barcode) {
    document.getElementById('usn').value = barcode;
    stopCamera();
    document.querySelector('form').submit();
}

function stopCamera() {
    if (scanning && codeReader) {
        codeReader.reset();
        scanning = false;
    }

    // Stop video stream
    if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
        currentStream = null;
    }

    document.getElementById('cameraDiv').style.display = 'none';
}

function checkForAutoRefresh() {
    // Check if any status message is displayed
    const statusMessages = [
        'text-primary',    // msg 1: Checked in
        'text-warning',    // msg 2: Wait to check out
        'text-danger',     // msg 3: Invalid ID
        'text-success',    // msg 4: Checked out
        'text-info'        // msg 5: Wait to check in
    ];

    let hasStatusMessage = false;

    statusMessages.forEach(className => {
        if (document.querySelector(`.animated.flash span.${className}`)) {
            hasStatusMessage = true;
        }
    });

    // Also check for IN/OUT status
    const hasStatusInOut = document.querySelector('.status-inout');

    // If we have any status message, set up auto-refresh
    if (hasStatusMessage || hasStatusInOut) {
        // Wait for animation to complete, then refresh
        setTimeout(function() {
            if (!scanning) {
                window.location.href = "/inout/dash.php";
            }
        }, 3000); // Refresh after 3 seconds for status messages
    } else {
        // No status message, use longer timeout for idle refresh
        setTimeout(function() {
            if (!scanning) {
                //window.location.href = "/inout/dash.php";
            }
        }, 8000); // Refresh after 8 seconds when idle
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on input
    document.getElementById("usn").focus();

    // Set up animation end listeners for auto-refresh
    const animatedElements = document.querySelectorAll('.animated');
    animatedElements.forEach(el => {
        el.addEventListener('animationend', function() {
            // Check if this is a status animation
            const isStatusElement = this.classList.contains('status-inout') ||
                                   this.closest('.animated.flash') !== null ||
                                   this.querySelector('span.text-primary, span.text-warning, span.text-danger, span.text-success, span.text-info');

            if (isStatusElement && !scanning) {
                setTimeout(function() {
                    window.location.href = "/inout/dash.php";
                }, 2000); 
            }
        }, { once: true });
    });

    // Fallback auto-refresh check
    checkForAutoRefresh();

    $(document).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        setTimeout(function() {
            if (!scanning) {
                window.location.href = "/inout/dash.php";
            }
        }, 200);
    });
});

</script>
<!-- editing ended by Devansh Gupta -->

<!-- MAIN CONTENT ENDS -->
<?php
	require_once "./template/footer.php";
?>	