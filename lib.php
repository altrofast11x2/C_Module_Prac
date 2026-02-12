<?php
function script($s)
{
    echo "<script>$s</script>";
}

function alert($m)
{
    script("alert('$m')");
}

function move($m, $a = null)
{
    if ($a) alert($a);
    script("location.href = '$m'");
    exit;
}
function back($a = null)
{
    if ($a) alert($a);
    script("history.back()");
    exit;
}
