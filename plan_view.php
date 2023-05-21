<?php
require_once 'apis/47Billing.class.php';

$obj = new Billing();
// $_GET["id"] = 24;

$plan = json_decode($obj->getSinglePlan($_GET["id"]));
$planFeatures = json_decode($obj->getPlanFeatures($_GET["id"]));

$features = [];

foreach($planFeatures as $pFeature){
    $features[] = $pFeature->featureId;
}

$features = json_decode($obj->getfeaturesList($features));
?>

<p><span class="font-weight-bolder">Plan Name</span> : <?php echo $plan->planName ?></p>
<p><span class="font-weight-bolder">Billing Term</span> : <?php echo $plan->billTerm ?></p>
<p><span class="font-weight-bolder">Amount </span> :
    <?php echo number_format((float)$plan->amount,2 ,".", ",") . " " . "KES" ?></p>

<h2>Features</h2>

<table class="table table-bordered">
    <thead>
        <th>Name</th>
        <th>Token</th>
    </thead>
    <tbody>
        <?php foreach($features as $feature) {
            echo '<tr><td>'.$feature->feature_name.'</td><td>'.number_format((float)$feature->token, 2, ".", ",").'</td></tr>';
        }?>
    </tbody>
</table>