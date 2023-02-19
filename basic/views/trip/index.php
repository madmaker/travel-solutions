<?php

use yii\grid\GridView;
?>
    <h1>Trips</h1>
<?php
echo GridView::widget([
    'dataProvider' => $tripsDataProvider,
]);?>