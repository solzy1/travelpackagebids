<?php 
    $title = 'Travel agents';

    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/admin/travel_agents/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/admin/layout.php';

    function main_body(){
    	$travel_agents = new Travel_Agents();
    	$page = isset($_GET['page']) ? $_GET['page'] : '';
        $search = get_searchvalues('travel-agents');
    ?>
    	<input type="hidden" id="page-url" value="travel_agents">

    	<div class="col-12 container-fluid filter">
            <!-- count travel_agents -->
            <!-- <div class="count-travel_agents row"> -->
                <!-- count package -->
               <!--  <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="package-count">
                        <h5>TODAY:</h5>
                        <h6><b>0</b> travel_agents</h6>
                    </div>
                </div> -->
                <!-- END count package -->
            <!-- </div> -->
            <!-- END count travel_agents -->

            <!-- search -->
            <div class="input-group mb-3">
                <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-package" id="search" value="<?php echo $search['value']; ?>">
                <!-- search filter -->
                <select class="form-select bg-secondary text-white" style="max-width: 140px;" id="search-filter">
                    <option value="" selected>Search for?</option>
                    <option>Email</option>
                    <option>Name</option>
                    <option>Phone number</option>
                    <option>Country</option>
                </select>
                <input type="hidden" class="search-filter" value="<?php echo $search['filter']; ?>">
                <!-- END search filter -->
                <button class="btn btn-primary" type="button" id="send-search"><i class="fas fa-search"></i></button>
            </div>
            <!-- END search -->
        </div>

        <div class="col-12" style="margin-top: 10px">
            <table class="table">
                <thead class="bg-dark table-head">
                    <tr>
                        <th scope="col"><input type="checkbox" name="all" class="form-check-input" id="check-all"></th>
                        <th scope="col">Email</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Country</th>
                        <th scope="col">Packages</th>
                        <th scope="col" class="bg-light" style="color: black !important">
                            <!-- action -->
                            <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>Action</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item btn btn-success" role="button" id="rows-activate">
                                        <i class="fas fa-circle-check"></i> Activate
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item btn btn-warning" role="button" id="rows-deactivate">
                                        <i class="fas fa-circle-pause"></i> De-activate
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item btn btn-danger" role="button" id="rows-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </li>
                            </ul>
                            <!-- END action -->
                        </th>
                    </tr>
                </thead>
                <tbody>
                	<?php 
                		$travel_agents->show($page);
                	?>
                </tbody>
            </table>

        </div>

<?php 
        $travel_agents->pagination($page);
    }
?>