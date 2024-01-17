<?php
//dd(Yii::$app->user->identity->getAttribute('username'));
echo 'Welcome '.'<span style="color:green;font-size:20px">'.Yii::$app->user->identity->getAttribute('username').'</span>,'.' you are logged in.';
echo Yii::$app->request->pathInfo;


?>