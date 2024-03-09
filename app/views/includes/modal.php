<div class="modal fade" id="addNewCar" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_new_vehicle_text">Add New Car</h5>
                <h5 class="modal-title" style="display: none;" id="edit_vehicle_text">Edit Vehicle</h5>
                <button type="button" class="btn-close" onclick="clear_all_inputs()" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group w-100 mb-4 mt-2">
                        <label class="control-label" for="vehicle_model">Vehicle Model</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control input-value" id="vehicle_model" placeholder="Enter Vehicle Model">
                            <p class="text-danger errorField fw-light"></p>
                        </div>
                    </div>
                    <div class="form-group w-100 my-4">
                        <label class="control-label" for="vehicle_number">Vehicle Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control input-value" id="vehicle_number" placeholder="Enter Vehicle Number">
                            <p class="text-danger errorField fw-light"></p>
                        </div>
                    </div>
                    <div class="form-group w-100 my-4">
                        <label class="control-label" for="seating_capacity">Seating Capacity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control input-value" id="seating_capacity" placeholder="Enter Seating Capcity">
                            <p class="text-danger errorField fw-light"></p>
                        </div>
                    </div>
                    <div class="form-group w-100 my-4">
                        <label class="control-label" for="rent_per_day">Rent Per Day</label>
                        <div class="col-sm-12">
                            <input type="number" min="0" class="form-control input-value" id="rent_per_day" placeholder="Enter Rent Per day">
                            <p class="text-danger errorField fw-light"></p>
                        </div>
                    </div>

                    <div class="form-group w-100 my-4">
                        <label class="control-label" for="image">Vehcile Image</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control input-value" id="image" placeholder="Choose image">
                            <p class="text-danger errorField fw-light"></p>
                        </div>
                    </div>

                    <input type="text" hidden class="input-value" id="old_image" name="vehicleID" value="12345678">
                    <input type="text" hidden class="input-value" id="car_id" name="vehicleID" value="12345678">

                    <div class="modal-footer d-flex justify-content-center">
                        <button class="btn btn-danger btn-lg" onclick="clear_all_inputs()" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-lg" onclick="validate_input(event)" id="add_new_car_btn">
                            <span class="mx-1">Submit</span>
                            <div class="spinner-border spinner-grow-sm" style="display: none;" role="status">
                            </div>
                        </button>
                        <button class="btn btn-primary btn-lg" onclick="validate_input(event, 'editVehicle')" style="display: none;" id="edit_car_btn">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>