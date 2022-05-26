<?php 
    $title = 'Travel agents';

    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/admin/travel_agents/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/admin/layout.php';

    function main_body(){
    	$travel_agents = new Travel_Agents();

    	$page = isset($_GET['page']) ? $_GET['page'] : '';

        $search = get_searchvalues('travel-agents');
        $bid_request = '';

        // ALLOW BID REQUEST
        if(isset($_GET['package']) && isset($_GET['bidding'])){ // remove the bidding (session), everytime the page reloads
            unset($_SESSION['travelpackagebids.com']['bidding']);
            $bid_request = $travel_agents->set_package($_GET['package'], $_GET['bidding']);
        }
    ?>
    	<input type="hidden" id="page-url" value="travel_agents">

    	<div class="col-12 container-fluid filter">
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
                    <option>State</option>
                    <option>Allowed to bid</option>
                    <option>Barred from bidding</option>
                </select>
                <input type="hidden" class="search-filter" value="<?php echo $search['filter']; ?>">
                <!-- END search filter -->
                <button class="btn btn-primary" type="button" id="send-search"><i class="fas fa-search"></i></button>
            </div>
            <!-- END search -->
        </div>

        <?php 
            // if a package was selected
            if($travel_agents->package_isset($bid_request)){
                $action = $bid_request['action']=='allow' ? 'Allow to Bid' : 'Prevent from Bidding';

                echo '<div style="color: black" class="lead text-center">Select the Travel-Agent(s), and Click "<b class="fw-bold">'.$action.'</b>" for the selected package <span style="font-size: 16px;color: grey">'.$bid_request['package_title'].'</span></div>';
            }
        ?>

        <div class="col-12" style="margin-top: 10px;max-width: 200vh;overflow-x: auto">
            <table class="table">
                <thead class="bg-dark table-head">
                    <tr>
                        <th scope="col"><input type="checkbox" name="all" class="form-check-input" id="check-all"></th>
                        <th scope="col">Email</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone number</th>
                        <th scope="col">Countries</th>
                        <th scope="col">States</th>
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
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item btn btn-danger <?php echo $travel_agents->no_bidding($bid_request, 'prevent'); ?>" role="button" id="rows-allow-bidding">
                                        <i class="fas fa-handshake"></i> Allow to Bid
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item btn btn-danger <?php echo $travel_agents->no_bidding($bid_request, 'allow'); ?>" role="button" id="rows-prevent-bidding">
                                        <i class="fas fa-handshake-slash"></i> Prevent from Bidding
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