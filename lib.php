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
}
function back($a = null)
{
    if ($a) alert($a);
    script("history.back()");
}
function ask_move($y, $m)
{
    echo "<script>confirm('$y');location.href='$m'</script>";
}
