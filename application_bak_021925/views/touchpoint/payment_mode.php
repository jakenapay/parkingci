<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Payment Mode Selection
            <small>Select Mode of Payment</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <div class="mop-container">
            <div class="mop-cards">
                <div class="mop-title">
                    <h4>Select a <span class="mop-tagline">Payment</span> mode.</h4>
                </div>
                <form action="<?php echo base_url('touchpoint/ModeForm') ?>" class="GET">
                    <input type="text" class="form-control" name="id" value="<?php echo $billdata['parkingId'];?>">
                    <input type="text" class="form-control" name="gate_id" value="<?php echo $billdata['gateEntry'];?>">
                    <input type="text" class="form-control" name="access_type" value="<?php echo $billdata['accessType'];?>">
                    <input type="text" class="form-control" name="parking_code" value="<?php echo $billdata['parkingCode'];?>">
                    <input type="text" class="form-control" name="unix_entry_time" value="<?php echo $billdata['entryTime'];?>">
                    <input type="text" class="form-control" name="paytime" value="<?php echo $billdata['paymentTime'];?>">
                    <input type="text" class="form-control" name="vehicle_class" value="<?php echo $billdata['vehicleClass'];?>">
                    <input type="text" class="form-control" name="parking_time" value="<?php echo $billdata['parkingTime'];?>">
                    <input type="text" class="form-control" name="amount_due" value="<?php echo $billdata['amount'];?>">
                    <input type="text" class="form-control" name="discount_opt" value="<?php echo $billdata['discount'];?>">
                    <input type="text" class="form-control" name="vehicle_rate" value="<?php echo $billdata['vehicleRate'];?>">
                    <input type="text" class="form-control" name="status" value="<?php echo $billdata['status'];?>">

                    <input type="radio" name="paymentmode" id="cash" value="Cash">
                    <input type="radio" name="paymentmode" id="gcash" value="Gcash">
                    <input type="radio" name="paymentmode" id="paymaya" value="Paymaya">
                    <input type="radio" name="paymentmode" id="complimentary" value="Complimentary">

                    <div class="mop-category">
                        <label for="cash" class="cashMethod">
                            <div class="imgName">
                                <div class="imgContainer cash">
                                    <img src="<?php echo base_url('assets/') ?>images/mode-3.png" alt="Cash Payment">
                                </div>
                                <span class="mop-name">Cash</span>
                            </div>
                            <span class="check">
                                <i class="fa fa-check"></i>
                            </span>
                        </label>
                        <label for="gcash" class="gcashMethod">
                            <div class="imgName">
                                <div class="imgContainer gcash">
                                    <img src="<?php echo base_url('assets/') ?>images/mode-2.png" alt="Gcash Payment">
                                </div>
                                <span class="mop-name">Gcash</span>
                            </div>
                            <span class="check">
                                <i class="fa fa-check"></i>
                            </span>
                        </label>
                        <label for="paymaya" class="paymayaMethod">
                            <div class="imgName">
                                <div class="imgContainer maya">
                                    <img src="<?php echo base_url('assets/') ?>images/mode-1.png" alt="Paymaya Payment">
                                </div>
                                <span class="mop-name">Paymaya</span>
                            </div>
                            <span class="check">
                                <i class="fa fa-check"></i>
                            </span>
                        </label>
                        <label for="complimentary" class="complimentaryMethod">
                        <div class="imgName">
                                <div class="imgContainer complimentary">
                                    <img src="<?php echo base_url('assets/') ?>images/mode-4.png" alt="Complimentary Payment">
                                </div>
                                <span class="mop-name">Complimentary</span>
                            </div>
                            <span class="check">
                                <i class="fa fa-check"></i>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Continue Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .mop-container{
        width: 100%;
        height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mop-cards{
        width: 400px;
        border-radius: 8px;
        padding: 40px;
        background: #fff;
        text-align: center;
        /* box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1),
                    0 5px 12px -2px rgba(0, 0, 0, 0.1),
                    0 18px 36px -6px rgba(0, 0, 0, 0.1); */
    }
    .mop-tagline{
        color: #006fff;
        font-size: 1.869rem;
        font-weight: 600;
    }
    .mop-container form input{
        display: none;
    }

    .mop-container form .mop-category{
        padding-top: 20px;
        margin-top: 10px;
    }

    .mop-category label{
        width: 100%;
        height: 65px;
        padding: 10px;
        box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        border-radius: 5px;
    }

    label .imgName {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    label:nth-child(2), label:nth-child(3){
        margin: 15px 0;
    }

    .imgName span{
        margin-left: 20px;
    }

    .imgName .imgContainer{
        width: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cash img{
        width: 60px;
    }

    .gcash img{
        width: 60px;
    }
    .maya img{
        width: 60px;
    }
    .complimentary img{
        width: 70px;
    }
    img{
        width: 50px;
        height: auto;
    }

    .check{
        display: none
    }
    .check i{
        color: #295F98;
        font-size: 1.200rem;
    }

    #cash:checked ~ .mop-category .cashMethod,
    #gcash:checked ~ .mop-category .gcashMethod,
    #paymaya:checked ~ .mop-category .paymayaMethod,
    #complimentary:checked ~ .mop-category .complimentaryMethod,{
        box-shadow: 0px 0px 0px 1px red;
    }
    #cash:checked ~ .mop-category .cashMethod .check,
    #gcash:checked ~ .mop-category .gcashMethod .check,
    #paymaya:checked ~ .mop-category .paymayaMethod .check,
    #complimentary:checked ~ .mop-category .complimentaryMethod .check{
        display: block;
    }
</style>