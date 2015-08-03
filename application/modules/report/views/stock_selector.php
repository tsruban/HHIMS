<?php
$model = "<div class=\"modal-dialog\">\n";
$model .= "    <div class=\"modal-content\">\n";
$model .= "        <div class=\"modal-header\">\n";
$model .= "            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>\n";
$model .= "            <h4 class=\"modal-title\">" . $title . "</h4>\n";
$model .= "        </div>\n";
$model .= "        <div class=\"modal-body\" style='padding-bottom: 5px;'>\n";
$model .= "            <table style=\"width: 100%\">\n";
$model .= "                <thead>\n";
$model .= "                <tr>\n";
$model .= "                    <th>Stock:".$stocks." </th>\n";
$model .= "                </tr>\n";
$model .= "                <tr>\n";
$model .= "                    <th>Stock less than: <input type=\"text\" class=\"span2\" value=\"1000\" id=\"stock\"></th>\n";
$model .= "                </tr>\n";
$model .= "                </thead>\n";
$model .= "            </table>\n";
if (isset($description)) {
    $model .= "            <div class='alert alert-info' style='margin-top:18px; '>\n";
    $model .= "            $description\n";
    $model .= "            </div>\n";
}
$model .= "        </div>\n";
$model .= "        <div class=\"modal-footer\">\n";
$model .= "            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n";
$model .= "            <button type=\"button\" class=\"btn btn-primary\" onclick='$id()'>Generate</button>\n";
$model .= "        </div>\n";
$model .= "    </div>\n";
$model .= "</div>";

$js = "<script type=\"text/javascript\">\n";
$js .= "    function $id() {\n";
$js .= "        var params = \"menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700\";\n";
$js .= "        var lookUpW = window.open(\"" . $url . "/\" + $(\"#stock\").val()+\"/\"+$(\"#stock_from\").val(), \"lookUpW\", params);\n";
$js .= "    }\n";
$js .= "</script>";

echo $model . $js;
?>