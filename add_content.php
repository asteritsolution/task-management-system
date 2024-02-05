<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="add-content-manager">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Date</label>
                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="" value="<?php echo isset($start_date) ? date("Y-m-d", strtotime($start_date)) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Important Date lists</label>
                            <select class="form-control form-control-sm select2" name="">
                                <option></option>
                                <?php
                                // Fetch names from the client table
                                $sql = "SELECT important_days FROM calendar";
                                $result = mysqli_query($conn, $sql);
                                // Populate the dropdown list
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['important_days'] . "'>" . $row['important_days'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Client Name</label>
                            <select class="form-control form-control-sm select2" name="">
                                <option></option>
                                <?php
                                // Fetch names from the client table
                                $sql = "SELECT name FROM client";
                                $result = mysqli_query($conn, $sql);
                                // Populate the dropdown list
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Project Team Members</label>
                            <select class="form-control form-control-sm select2" multiple="multiple" name="">
                                <option></option>
                                <?php
                                $employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
                                while ($row = $employees->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'], explode(',', $user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="control-label">Description</label>
                            <textarea name="" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="add-content-manager">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
            </div>
        </div>
    </div>
</div>