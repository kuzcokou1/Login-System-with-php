<?php 

	include 'header.php'; 

	require 'includes/dbh.inc.php';
	require 'includes/functions.php';

	if (isset($_POST['submit'])) {
		$organizer = mysqli_real_escape_string($conn, $_POST['organizer']);
		$phone = mysqli_real_escape_string($conn, $_POST['phone']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);

		$eventName = mysqli_real_escape_string($conn, $_POST['e_name']);
		$eventDate = mysqli_real_escape_string($conn, $_POST['eventDate']);
		$eventTime = mysqli_real_escape_string($conn, $_POST['eventTime']);
		$eventLocation = mysqli_real_escape_string($conn, $_POST['eventLocation']);
		$eventDetails = mysqli_real_escape_string($conn, $_POST['details']);


		$target_dir = "assets/img/events/";
		$target_file = $target_dir . basename($_FILES['eventFile']['name']);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		if (is_array($_FILES)) {
	        if (is_uploaded_file($_FILES['eventFile']['tmp_name'])) {
	            $imageFile = $_FILES['eventFile']['name'];
	            $guestFile = $_FILES['guestImage']['name'];
	            $path = $_FILES['eventFile']['tmp_name'];
	            $pathGuest = $_FILES['guestImage']['tmp_name'];
	            $targetDirEvent = $target_dir . $_FILES['eventFile']['name'];
	            $targetDir = $target_dir . $_FILES['guestImage']['name'];

	            if (move_uploaded_file($path, $targetDirEvent)) {
	               	$sqlInsert = "INSERT INTO `tbl_events`(`organizer`, `o_phone`, `o_email`, `o_address`, `e_date`, `e_time`, `e_location`, `e_name`, `e_details`, `e_image`) VALUES ('$organizer', '$phone', '$email', '$address', '$eventDate', '$eventTime', '$eventLocation', '$eventName', '$eventDetails', '$imageFile')";	

					mysqli_query($conn, $sqlInsert);

					if (move_uploaded_file($pathGuest, $target_dir)) {
						$lastInsertId = mysqli_insert_id($conn);

						for ($i = 0; $i < count($POST['itemNo']); $i++) {
							$sqlInsertItem = "INSERT INTO `tbl_guests_item`(`e_id`, `guest_no`, `guest_name`, `guest_designation`, `guest_image`, `item_no`, `time_from`, `time_to`, `speech_from`, `s_description`) VALUES ('".$lastInsertId."', '".$POST['guestNo'][$i]."', '".$POST['guestName'][$i]."', '".$POST['guestDesignation'][$i]."', '".$POST['guestFile'][$i]."', '".$POST['itemNo'][$i]."', '".$POST['from'][$i]."', '".$POST['to'][$i]."', '".$POST['speechFrom'][$i]."', '".$POST['description'][$i]."')";			
							mysqli_query($conn, $sqlInsertItem);
						} 
					}
	               	echo("<script type='text/javascript'>window.location = 'events.php?create=success'; </script>");
	            }
	        }
	    }
	}
?>

<title>Warrap State | Create Event</title>

	<div class="content">
        <div class="container-fluid">
        	<div class="row">
	            <div class="col-md-12">
	              	<div class="card">
		                <div class="card-header card-header-primary">
		                  	<h4 class="card-title ">Manage Events</h4>
		                  	<p class="card-category">Create A New Event</p>
		                </div>
		                <div class="card-body">
	                    	<form action="" method="POST" enctype="multipart/form-data">
	                    		<h4 class="font-weight-bold">Organizer's  Information</h4>
		                    	<div class="row">
			                      	<div class="col-md-6">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Organizer</label>
				                          	<input type="text" name="organizer" autofocus class="form-control">
				                        </div>
			                      	</div>
			                      	<div class="col-md-6">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Phone</label>
				                          	<input type="text" name="phone" class="form-control">
				                        </div>
			                      	</div>
			                    </div>

			                    <div class="row">
			                      	<div class="col-md-6">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Email</label>
				                          	<input type="email" name="email" class="form-control">
				                        </div>
			                      	</div>
			                      	<div class="col-md-6">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Address</label>
				                          	<input type="text" name="address" class="form-control">
				                        </div>
			                      	</div>
			                    </div>

			                    <h4 class="mt-3 mb-4 font-weight-bold">Event Information</h4>

			                    <div class="row">
			                      	<div class="col-md-3">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Event Date</label>
				                          	<input type="date" name="eventDate" autofocus class="form-control">
				                        </div>
			                      	</div>
			                      	<div class="col-md-3">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Event Time</label>
				                          	<input type="time" name="eventTime" autofocus class="form-control">
				                        </div>
			                      	</div>
			                      	<div class="col-md-6">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Event Location</label>
				                          	<input type="text" name="eventLocation" class="form-control">
				                        </div>
			                      	</div>
			                    </div>

			                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Event Name</label>
                                            <div class="form-group">
                                                <input type="text" name="e_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

			                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Event Details</label>
                                            <div class="form-group">
                                                <textarea class="form-control" name="details" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                	<div class="col-md-12">
				                        <div class="form-group">
				                          	<label class="bmd-label-floating">Event Image</label>
				                          	<div class="input-group">
						                        <span class="input-group-btn">
						                            <span class="btn btn-file">
						                                Browse File&hellip; <input type="file" id="fileupload" name="eventFile" multiple>
						                            </span>
						                        </span>
						                    </div>
				                        </div>
			                      	</div>
                                </div>

                                <div class="row">
	                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                                    <table class="table table-condensed table-striped" id="eventItem">
	                                        <tr>
	                                            <th width="2%">
	                                                <div class="custom-control custom-checkbox mb-3">
	                                                    <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
	                                                    <label class="custom-control-label" for="checkAll"></label>
	                                                </div>
	                                            </th>
	                                            <th width="10%">Item No</th>
	                                            <th width="10%">From</th>
	                                            <th width="10%">To</th>
	                                            <th width="40%">Speech From</th>
	                                            <th width="30%">Description</th>
	                                        </tr>
	                                        <tr>
	                                            <td>
	                                                <div class="custom-control custom-checkbox">
	                                                    <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
	                                                    <label class="custom-control-label" for="itemRow_1"></label>
	                                                </div>
	                                            </td>

	                                            <td>
	                                            	<input type="number" name="itemNo[]" id="itemNo_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="time" name="from[]" id="from_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="time" name="to[]" id="to_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="text" name="speechFrom[]" id="speechFrom_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="text" name="description[]" id="description_1" class="form-control" autocomplete="off">
	                                            </td>


	                                        </tr>
	                                    </table>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col-xs-12">
	                                    <button class="btn btn-danger delete" id="removeRowsEvent" type="button">- Delete</button>
	                                    <button class="btn btn-success" id="addRowsEvent" type="button">+ Add More</button>
	                                </div>
	                            </div>

			                    <h4 class="mt-5 mb-4 font-weight-bold">Special Guests List</h4>

			                    <div class="row">
	                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                                    <table class="table table-condensed table-striped" id="guests">
	                                        <tr>
	                                            <th width="2%">
	                                                <div class="custom-control custom-checkbox mb-3">
	                                                    <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
	                                                    <label class="custom-control-label" for="checkAll"></label>
	                                                </div>
	                                            </th>
	                                            <th width="15%">Guest No</th>
	                                            <th width="38%">Guest Name</th>
	                                            <th width="25%">Guest Designation</th>
	                                            <th width="20%">Guest Image</th>
	                                        </tr>
	                                        <tr>
	                                            <td>
	                                                <div class="custom-control custom-checkbox">
	                                                    <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
	                                                    <label class="custom-control-label" for="itemRow_1"></label>
	                                                </div>
	                                            </td>

	                                            <td>
	                                            	<input type="number" name="guestNo[]" id="guestNo_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="text" name="guestName[]" id="guestName_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="text" name="guestDesignation[]" id="guestDesignation_1" class="form-control" autocomplete="off">
	                                            </td>

	                                            <td>
	                                            	<input type="file" name="guestImage[]" id="guestImage_1" class="form-control quantity" autocomplete="off">
	                                            </td>


	                                        </tr>
	                                    </table>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col-xs-12">
	                                    <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
	                                    <button class="btn btn-success" id="addRows" type="button">+ Add More</button>
	                                </div>
	                            </div>

			                    <button type="submit" name="submit" class="btn btn-primary float-right">create Event</button>
			                    <div class="clearfix"></div>
			                </form>
		                </div>
	              	</div>
	            </div>
	        </div>
        </div>
    </div>

<?php include 'footer.php'; ?>