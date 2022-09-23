<?php
/** Adminer Editor - Compact database editor
 * @link https://www.adminer.org/
 * @author Jakub Vrana, https://www.vrana.cz/
 * @copyright 2009 Jakub Vrana
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 * @version 4.7.1
 */
error_reporting(6135);
$Kb = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($Kb || ini_get("filter.default_flags")) {
    foreach (array('_GET', '_POST', '_COOKIE', '_SERVER') as $W) {
        $Ue = filter_input_array(constant("INPUT$W"), FILTER_UNSAFE_RAW);
        if ($Ue) $$W = $Ue;
    }
}
if (function_exists("mb_internal_encoding")) mb_internal_encoding("8bit");
function
connection()
{
    global $h;
    return $h;
}

function
adminer()
{
    global $c;
    return $c;
}

function
version()
{
    global $ba;
    return $ba;
}

function
idf_unescape($u)
{
    $Bc = substr($u, -1);
    return
        str_replace($Bc . $Bc, $Bc, substr($u, 1, -1));
}

function
escape_string($W)
{
    return
        substr(q($W), 1, -1);
}

function
number($W)
{
    return
        preg_replace('~[^0-9]+~', '', $W);
}

function
number_type()
{
    return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}

function
remove_slashes($_d, $Kb = false)
{
    if (get_magic_quotes_gpc()) {
        while (list($y, $W) = each($_d)) {
            foreach ($W
                     as $vc => $V) {
                unset($_d[$y][$vc]);
                if (is_array($V)) {
                    $_d[$y][stripslashes($vc)] = $V;
                    $_d[] =& $_d[$y][stripslashes($vc)];
                } else$_d[$y][stripslashes($vc)] = ($Kb ? $V : stripslashes($V));
            }
        }
    }
}

function
bracket_escape($u, $ua = false)
{
    static $Je = array(':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4');
    return
        strtr($u, ($ua ? array_flip($Je) : $Je));
}

function
min_version($cf, $Kc = "", $i = null)
{
    global $h;
    if (!$i) $i = $h;
    $Yd = $i->server_info;
    if ($Kc && preg_match('~([\d.]+)-MariaDB~', $Yd, $B)) {
        $Yd = $B[1];
        $cf = $Kc;
    }
    return (version_compare($Yd, $cf) >= 0);
}

function
charset($h)
{
    return (min_version("5.5.3", 0, $h) ? "utf8mb4" : "utf8");
}

function
script($fe, $Ie = "\n")
{
    return "<script" . nonce() . ">$fe</script>$Ie";
}

function
script_src($Ze)
{
    return "<script src='" . h($Ze) . "'" . nonce() . "></script>\n";
}

function
nonce()
{
    return ' nonce="' . get_nonce() . '"';
}

function
target_blank()
{
    return ' target="_blank" rel="noreferrer noopener"';
}

function
h($me)
{
    return
        str_replace("\0", "&#0;", htmlspecialchars($me, ENT_QUOTES, 'utf-8'));
}

function
nl_br($me)
{
    return
        str_replace("\n", "<br>", $me);
}

function
checkbox($E, $X, $Fa, $yc = "", $dd = "", $Ia = "", $zc = "")
{
    $M = "<input type='checkbox' name='$E' value='" . h($X) . "'" . ($Fa ? " checked" : "") . ($zc ? " aria-labelledby='$zc'" : "") . ">" . ($dd ? script("qsl('input').onclick = function () { $dd };", "") : "");
    return ($yc != "" || $Ia ? "<label" . ($Ia ? " class='$Ia'" : "") . ">$M" . h($yc) . "</label>" : $M);
}

function
optionlist($G, $Td = null, $af = false)
{
    $M = "";
    foreach ($G
             as $vc => $V) {
        $hd = array($vc => $V);
        if (is_array($V)) {
            $M .= '<optgroup label="' . h($vc) . '">';
            $hd = $V;
        }
        foreach ($hd
                 as $y => $W) $M .= '<option' . ($af || is_string($y) ? ' value="' . h($y) . '"' : '') . (($af || is_string($y) ? (string)$y : $W) === $Td ? ' selected' : '') . '>' . h($W);
        if (is_array($V)) $M .= '</optgroup>';
    }
    return $M;
}

function
html_select($E, $G, $X = "", $cd = true, $zc = "")
{
    if ($cd) return "<select name='" . h($E) . "'" . ($zc ? " aria-labelledby='$zc'" : "") . ">" . optionlist($G, $X) . "</select>" . (is_string($cd) ? script("qsl('select').onchange = function () { $cd };", "") : "");
    $M = "";
    foreach ($G
             as $y => $W) $M .= "<label><input type='radio' name='" . h($E) . "' value='" . h($y) . "'" . ($y == $X ? " checked" : "") . ">" . h($W) . "</label>";
    return $M;
}

function
select_input($d, $G, $X = "", $cd = "", $sd = "")
{
    $we = ($G ? "select" : "input");
    return "<$we$d" . ($G ? "><option value=''>$sd" . optionlist($G, $X, true) . "</select>" : " size='10' value='" . h($X) . "' placeholder='$sd'>") . ($cd ? script("qsl('$we').onchange = $cd;", "") : "");
}

function
confirm($C = "", $Ud = "qsl('input')")
{
    return
        script("$Ud.onclick = function () { return confirm('" . ($C ? js_escape($C) : lang(0)) . "'); };", "");
}

function
print_fieldset($t, $Dc, $ff = false)
{
    echo "<fieldset><legend>", "<a href='#fieldset-$t'>$Dc</a>", script("qsl('a').onclick = partial(toggle, 'fieldset-$t');", ""), "</legend>", "<div id='fieldset-$t'" . ($ff ? "" : " class='hidden'") . ">\n";
}

function
bold($Aa, $Ia = "")
{
    return ($Aa ? " class='active $Ia'" : ($Ia ? " class='$Ia'" : ""));
}

function
odd($M = ' class="odd"')
{
    static $s = 0;
    if (!$M) $s = -1;
    return ($s++ % 2 ? $M : '');
}

function
js_escape($me)
{
    return
        addcslashes($me, "\r\n'\\/");
}

function
json_row($y, $W = null)
{
    static $Lb = true;
    if ($Lb) echo "{";
    if ($y != "") {
        echo ($Lb ? "" : ",") . "\n\t\"" . addcslashes($y, "\r\n\t\"\\/") . '": ' . ($W !== null ? '"' . addcslashes($W, "\r\n\"\\/") . '"' : 'null');
        $Lb = false;
    } else {
        echo "\n}\n";
        $Lb = true;
    }
}

function
ini_bool($pc)
{
    $W = ini_get($pc);
    return (preg_match('~^(on|true|yes)$~i', $W) || (int)$W);
}

function
sid()
{
    static $M;
    if ($M === null) $M = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
    return $M;
}

function
set_password($Y, $Q, $U, $J)
{
    $_SESSION["pwds"][$Y][$Q][$U] = ($_COOKIE["adminer_key"] && is_string($J) ? array(encrypt_string($J, $_COOKIE["adminer_key"])) : $J);
}

function
get_password()
{
    $M = get_session("pwds");
    if (is_array($M)) $M = ($_COOKIE["adminer_key"] ? decrypt_string($M[0], $_COOKIE["adminer_key"]) : false);
    return $M;
}

function
q($me)
{
    global $h;
    return $h->quote($me);
}

function
get_vals($K, $e = 0)
{
    global $h;
    $M = array();
    $L = $h->query($K);
    if (is_object($L)) {
        while ($N = $L->fetch_row()) $M[] = $N[$e];
    }
    return $M;
}

function
get_key_vals($K, $i = null, $be = true)
{
    global $h;
    if (!is_object($i)) $i = $h;
    $M = array();
    $L = $i->query($K);
    if (is_object($L)) {
        while ($N = $L->fetch_row()) {
            if ($be) $M[$N[0]] = $N[1]; else$M[] = $N[0];
        }
    }
    return $M;
}

function
get_rows($K, $i = null, $l = "<p class='error'>")
{
    global $h;
    $Sa = (is_object($i) ? $i : $h);
    $M = array();
    $L = $Sa->query($K);
    if (is_object($L)) {
        while ($N = $L->fetch_assoc()) $M[] = $N;
    } elseif (!$L && !is_object($i) && $l && defined("PAGE_HEADER")) echo $l . error() . "\n";
    return $M;
}

function
unique_array($N, $v)
{
    foreach ($v
             as $nc) {
        if (preg_match("~PRIMARY|UNIQUE~", $nc["type"])) {
            $M = array();
            foreach ($nc["columns"] as $y) {
                if (!isset($N[$y])) continue
                2;
                $M[$y] = $N[$y];
            }
            return $M;
        }
    }
}

function
escape_key($y)
{
    if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $y, $B)) return $B[1] . idf_escape(idf_unescape($B[2])) . $B[3];
    return
        idf_escape($y);
}

function
where($Z, $n = array())
{
    global $h, $x;
    $M = array();
    foreach ((array)$Z["where"] as $y => $W) {
        $y = bracket_escape($y, 1);
        $e = escape_key($y);
        $M[] = $e . ($x == "sql" && preg_match('~^[0-9]*\.[0-9]*$~', $W) ? " LIKE " . q(addcslashes($W, "%_\\")) : ($x == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $W)) : " = " . unconvert_field($n[$y], q($W))));
        if ($x == "sql" && preg_match('~char|text~', $n[$y]["type"]) && preg_match("~[^ -@]~", $W)) $M[] = "$e = " . q($W) . " COLLATE " . charset($h) . "_bin";
    }
    foreach ((array)$Z["null"] as $y) $M[] = escape_key($y) . " IS NULL";
    return
        implode(" AND ", $M);
}

function
where_check($W, $n = array())
{
    parse_str($W, $Ea);
    remove_slashes(array(&$Ea));
    return
        where($Ea, $n);
}

function
where_link($s, $e, $X, $fd = "=")
{
    return "&where%5B$s%5D%5Bcol%5D=" . urlencode($e) . "&where%5B$s%5D%5Bop%5D=" . urlencode(($X !== null ? $fd : "IS NULL")) . "&where%5B$s%5D%5Bval%5D=" . urlencode($X);
}

function
convert_fields($f, $n, $P = array())
{
    $M = "";
    foreach ($f
             as $y => $W) {
        if ($P && !in_array(idf_escape($y), $P)) continue;
        $oa = convert_field($n[$y]);
        if ($oa) $M .= ", $oa AS " . idf_escape($y);
    }
    return $M;
}

function
cookie($E, $X, $Gc = 2592000)
{
    global $aa;
    return
        header("Set-Cookie: $E=" . urlencode($X) . ($Gc ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $Gc) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($aa ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}

function
restart_session()
{
    if (!ini_bool("session.use_cookies")) session_start();
}

function
stop_session($Nb = false)
{
    if (!ini_bool("session.use_cookies") || ($Nb && @ini_set("session.use_cookies", false) !== false)) session_write_close();
}

function&get_session($y)
{
    return $_SESSION[$y][DRIVER][SERVER][$_GET["username"]];
}

function
set_session($y, $W)
{
    $_SESSION[$y][DRIVER][SERVER][$_GET["username"]] = $W;
}

function
auth_url($Y, $Q, $U, $j = null)
{
    global $mb;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($mb)) . "|username|" . ($j !== null ? "db|" : "") . session_name()), $B);
    return "$B[1]?" . (sid() ? SID . "&" : "") . ($Y != "server" || $Q != "" ? urlencode($Y) . "=" . urlencode($Q) . "&" : "") . "username=" . urlencode($U) . ($j != "" ? "&db=" . urlencode($j) : "") . ($B[2] ? "&$B[2]" : "");
}

function
is_ajax()
{
    return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}

function
redirect($A, $C = null)
{
    if ($C !== null) {
        restart_session();
        $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($A !== null ? $A : $_SERVER["REQUEST_URI"]))][] = $C;
    }
    if ($A !== null) {
        if ($A == "") $A = ".";
        header("Location: $A");
        exit;
    }
}

function
query_redirect($K, $A, $C, $Hd = true, $Cb = true, $Fb = false, $Ae = "")
{
    global $h, $l, $c;
    if ($Cb) {
        $je = microtime(true);
        $Fb = !$h->query($K);
        $Ae = format_time($je);
    }
    $he = "";
    if ($K) $he = $c->messageQuery($K, $Ae, $Fb);
    if ($Fb) {
        $l = error() . $he . script("messagesPrint();");
        return
            false;
    }
    if ($Hd) redirect($A, $C . $he);
    return
        true;
}

function
queries($K)
{
    global $h;
    static $Cd = array();
    static $je;
    if (!$je) $je = microtime(true);
    if ($K === null) return
        array(implode("\n", $Cd), format_time($je));
    $Cd[] = (preg_match('~;$~', $K) ? "DELIMITER ;;\n$K;\nDELIMITER " : $K) . ";";
    return $h->query($K);
}

function
apply_queries($K, $ve, $_b = 'table')
{
    foreach ($ve
             as $S) {
        if (!queries("$K " . $_b($S))) return
            false;
    }
    return
        true;
}

function
queries_redirect($A, $C, $Hd)
{
    list($Cd, $Ae) = queries(null);
    return
        query_redirect($Cd, $A, $C, $Hd, false, !$Hd, $Ae);
}

function
format_time($je)
{
    return
        lang(1, max(0, microtime(true) - $je));
}

function
remove_from_uri($nd = "")
{
    return
        substr(preg_replace("~(?<=[?&])($nd" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', "$_SERVER[REQUEST_URI]&"), 0, -1);
}

function
pagination($I, $ab)
{
    return " " . ($I == $ab ? $I + 1 : '<a href="' . h(remove_from_uri("page") . ($I ? "&page=$I" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($I + 1) . "</a>");
}

function
get_file($y, $eb = false)
{
    $Ib = $_FILES[$y];
    if (!$Ib) return
        null;
    foreach ($Ib
             as $y => $W) $Ib[$y] = (array)$W;
    $M = '';
    foreach ($Ib["error"] as $y => $l) {
        if ($l) return $l;
        $E = $Ib["name"][$y];
        $Ge = $Ib["tmp_name"][$y];
        $Ta = file_get_contents($eb && preg_match('~\.gz$~', $E) ? "compress.zlib://$Ge" : $Ge);
        if ($eb) {
            $je = substr($Ta, 0, 3);
            if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $je, $Id)) $Ta = iconv("utf-16", "utf-8", $Ta); elseif ($je == "\xEF\xBB\xBF") $Ta = substr($Ta, 3);
            $M .= $Ta . "\n\n";
        } else$M .= $Ta;
    }
    return $M;
}

function
upload_error($l)
{
    $Oc = ($l == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
    return ($l ? lang(2) . ($Oc ? " " . lang(3, $Oc) : "") : lang(4));
}

function
repeat_pattern($qd, $Ec)
{
    return
        str_repeat("$qd{0,65535}", $Ec / 65535) . "$qd{0," . ($Ec % 65535) . "}";
}

function
is_utf8($W)
{
    return (preg_match('~~u', $W) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $W));
}

function
shorten_utf8($me, $Ec = 80, $qe = "")
{
    if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $Ec) . ")($)?)u", $me, $B)) preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $Ec) . ")($)?)", $me, $B);
    return
        h($B[1]) . $qe . (isset($B[2]) ? "" : "<i>…</i>");
}

function
format_number($W)
{
    return
        strtr(number_format($W, 0, ".", lang(5)), preg_split('~~u', lang(6), -1, PREG_SPLIT_NO_EMPTY));
}

function
friendly_url($W)
{
    return
        preg_replace('~[^a-z0-9_]~i', '-', $W);
}

function
hidden_fields($_d, $mc = array())
{
    $M = false;
    while (list($y, $W) = each($_d)) {
        if (!in_array($y, $mc)) {
            if (is_array($W)) {
                foreach ($W
                         as $vc => $V) $_d[$y . "[$vc]"] = $V;
            } else {
                $M = true;
                echo '<input type="hidden" name="' . h($y) . '" value="' . h($W) . '">';
            }
        }
    }
    return $M;
}

function
hidden_fields_get()
{
    echo(sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : ''), (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : ""), '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}

function
table_status1($S, $Gb = false)
{
    $M = table_status($S, $Gb);
    return ($M ? $M : array("Name" => $S));
}

function
column_foreign_keys($S)
{
    global $c;
    $M = array();
    foreach ($c->foreignKeys($S) as $Rb) {
        foreach ($Rb["source"] as $W) $M[$W][] = $Rb;
    }
    return $M;
}

function
enum_input($Ne, $d, $m, $X, $vb = null)
{
    global $c;
    preg_match_all("~'((?:[^']|'')*)'~", $m["length"], $Lc);
    $M = ($vb !== null ? "<label><input type='$Ne'$d value='$vb'" . ((is_array($X) ? in_array($vb, $X) : $X === 0) ? " checked" : "") . "><i>" . lang(7) . "</i></label>" : "");
    foreach ($Lc[1] as $s => $W) {
        $W = stripcslashes(str_replace("''", "'", $W));
        $Fa = (is_int($X) ? $X == $s + 1 : (is_array($X) ? in_array($s + 1, $X) : $X === $W));
        $M .= " <label><input type='$Ne'$d value='" . ($s + 1) . "'" . ($Fa ? ' checked' : '') . '>' . h($c->editVal($W, $m)) . '</label>';
    }
    return $M;
}

function
input($m, $X, $q)
{
    global $Pe, $c, $x;
    $E = h(bracket_escape($m["field"]));
    echo "<td class='function'>";
    if (is_array($X) && !$q) {
        $na = array($X);
        if (version_compare(PHP_VERSION, 5.4) >= 0) $na[] = JSON_PRETTY_PRINT;
        $X = call_user_func_array('json_encode', $na);
        $q = "json";
    }
    $Ld = ($x == "mssql" && $m["auto_increment"]);
    if ($Ld && !$_POST["save"]) $q = null;
    $Wb = (isset($_GET["select"]) || $Ld ? array("orig" => lang(8)) : array()) + $c->editFunctions($m);
    $d = " name='fields[$E]'";
    if ($m["type"] == "enum") echo
        h($Wb[""]) . "<td>" . $c->editInput($_GET["edit"], $m, $d, $X); else {
        $cc = (in_array($q, $Wb) || isset($Wb[$q]));
        echo (count($Wb) > 1 ? "<select name='function[$E]'>" . optionlist($Wb, $q === null || $cc ? $q : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($Wb))) . '<td>';
        $rc = $c->editInput($_GET["edit"], $m, $d, $X);
        if ($rc != "") echo $rc; elseif (preg_match('~bool~', $m["type"])) echo "<input type='hidden'$d value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $X) ? " checked='checked'" : "") . "$d value='1'>";
        elseif ($m["type"] == "set") {
            preg_match_all("~'((?:[^']|'')*)'~", $m["length"], $Lc);
            foreach ($Lc[1] as $s => $W) {
                $W = stripcslashes(str_replace("''", "'", $W));
                $Fa = (is_int($X) ? ($X >> $s) & 1 : in_array($W, explode(",", $X), true));
                echo " <label><input type='checkbox' name='fields[$E][$s]' value='" . (1 << $s) . "'" . ($Fa ? ' checked' : '') . ">" . h($c->editVal($W, $m)) . '</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $m["type"]) && ini_bool("file_uploads")) echo "<input type='file' name='fields-$E'>";
        elseif (($ye = preg_match('~text|lob~', $m["type"])) || preg_match("~\n~", $X)) {
            if ($ye && $x != "sqlite") $d .= " cols='50' rows='12'"; else {
                $O = min(12, substr_count($X, "\n") + 1);
                $d .= " cols='30' rows='$O'" . ($O == 1 ? " style='height: 1.2em;'" : "");
            }
            echo "<textarea$d>" . h($X) . '</textarea>';
        } elseif ($q == "json" || preg_match('~^jsonb?$~', $m["type"])) echo "<textarea$d cols='50' rows='12' class='jush-js'>" . h($X) . '</textarea>';
        else {
            $Qc = (!preg_match('~int~', $m["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $m["length"], $B) ? ((preg_match("~binary~", $m["type"]) ? 2 : 1) * $B[1] + ($B[3] ? 1 : 0) + ($B[2] && !$m["unsigned"] ? 1 : 0)) : ($Pe[$m["type"]] ? $Pe[$m["type"]] + ($m["unsigned"] ? 0 : 1) : 0));
            if ($x == 'sql' && min_version(5.6) && preg_match('~time~', $m["type"])) $Qc += 7;
            echo "<input" . ((!$cc || $q === "") && preg_match('~(?<!o)int(?!er)~', $m["type"]) && !preg_match('~\[\]~', $m["full_type"]) ? " type='number'" : "") . " value='" . h($X) . "'" . ($Qc ? " data-maxlength='$Qc'" : "") . (preg_match('~char|binary~', $m["type"]) && $Qc > 20 ? " size='40'" : "") . "$d>";
        }
        echo $c->editHint($_GET["edit"], $m, $X);
        $Lb = 0;
        foreach ($Wb
                 as $y => $W) {
            if ($y === "" || !$W) break;
            $Lb++;
        }
        if ($Lb) echo
        script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Lb), oninput: function () { this.onchange(); }});");
    }
}

function
process_input($m)
{
    global $c, $k;
    $u = bracket_escape($m["field"]);
    $q = $_POST["function"][$u];
    $X = $_POST["fields"][$u];
    if ($m["type"] == "enum") {
        if ($X == -1) return
            false;
        if ($X == "") return "NULL";
        return +$X;
    }
    if ($m["auto_increment"] && $X == "") return
        null;
    if ($q == "orig") return (preg_match('~^CURRENT_TIMESTAMP~i', $m["on_update"]) ? idf_escape($m["field"]) : false);
    if ($q == "NULL") return "NULL";
    if ($m["type"] == "set") return
        array_sum((array)$X);
    if ($q == "json") {
        $q = "";
        $X = json_decode($X, true);
        if (!is_array($X)) return
            false;
        return $X;
    }
    if (preg_match('~blob|bytea|raw|file~', $m["type"]) && ini_bool("file_uploads")) {
        $Ib = get_file("fields-$u");
        if (!is_string($Ib)) return
            false;
        return $k->quoteBinary($Ib);
    }
    return $c->processInput($m, $X, $q);
}

function
fields_from_edit()
{
    global $k;
    $M = array();
    foreach ((array)$_POST["field_keys"] as $y => $W) {
        if ($W != "") {
            $W = bracket_escape($W);
            $_POST["function"][$W] = $_POST["field_funs"][$y];
            $_POST["fields"][$W] = $_POST["field_vals"][$y];
        }
    }
    foreach ((array)$_POST["fields"] as $y => $W) {
        $E = bracket_escape($y, 1);
        $M[$E] = array("field" => $E, "privileges" => array("insert" => 1, "update" => 1), "null" => 1, "auto_increment" => ($y == $k->primary),);
    }
    return $M;
}

function
search_tables()
{
    global $c, $h;
    $_GET["where"][0]["val"] = $_POST["query"];
    $Wd = "<ul>\n";
    foreach (table_status('', true) as $S => $T) {
        $E = $c->tableName($T);
        if (isset($T["Engine"]) && $E != "" && (!$_POST["tables"] || in_array($S, $_POST["tables"]))) {
            $L = $h->query("SELECT" . limit("1 FROM " . table($S), " WHERE " . implode(" AND ", $c->selectSearchProcess(fields($S), array())), 1));
            if (!$L || $L->fetch_row()) {
                $yd = "<a href='" . h(ME . "select=" . urlencode($S) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$E</a>";
                echo "$Wd<li>" . ($L ? $yd : "<p class='error'>$yd: " . error()) . "\n";
                $Wd = "";
            }
        }
    }
    echo ($Wd ? "<p class='message'>" . lang(9) : "</ul>") . "\n";
}

function
dump_headers($kc, $Tc = false)
{
    global $c;
    $M = $c->dumpHeaders($kc, $Tc);
    $kd = $_POST["output"];
    if ($kd != "text") header("Content-Disposition: attachment; filename=" . $c->dumpFilename($kc) . ".$M" . ($kd != "file" && !preg_match('~[^0-9a-z]~', $kd) ? ".$kd" : ""));
    session_write_close();
    ob_flush();
    flush();
    return $M;
}

function
dump_csv($N)
{
    foreach ($N
             as $y => $W) {
        if (preg_match("~[\"\n,;\t]~", $W) || $W === "") $N[$y] = '"' . str_replace('"', '""', $W) . '"';
    }
    echo
        implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $N) . "\r\n";
}

function
apply_sql_function($q, $e)
{
    return ($q ? ($q == "unixepoch" ? "DATETIME($e, '$q')" : ($q == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$q(")) . "$e)") : $e);
}

function
get_temp_dir()
{
    $M = ini_get("upload_tmp_dir");
    if (!$M) {
        if (function_exists('sys_get_temp_dir')) $M = sys_get_temp_dir(); else {
            $o = @tempnam("", "");
            if (!$o) return
                false;
            $M = dirname($o);
            unlink($o);
        }
    }
    return $M;
}

function
file_open_lock($o)
{
    $p = @fopen($o, "r+");
    if (!$p) {
        $p = @fopen($o, "w");
        if (!$p) return;
        chmod($o, 0660);
    }
    flock($p, LOCK_EX);
    return $p;
}

function
file_write_unlock($p, $bb)
{
    rewind($p);
    fwrite($p, $bb);
    ftruncate($p, strlen($bb));
    flock($p, LOCK_UN);
    fclose($p);
}

function
password_file($Va)
{
    $o = get_temp_dir() . "/adminer.key";
    $M = @file_get_contents($o);
    if ($M || !$Va) return $M;
    $p = @fopen($o, "w");
    if ($p) {
        chmod($o, 0660);
        $M = rand_string();
        fwrite($p, $M);
        fclose($p);
    }
    return $M;
}

function
rand_string()
{
    return
        md5(uniqid(mt_rand(), true));
}

function
select_value($W, $_, $m, $ze)
{
    global $c;
    if (is_array($W)) {
        $M = "";
        foreach ($W
                 as $vc => $V) $M .= "<tr>" . ($W != array_values($W) ? "<th>" . h($vc) : "") . "<td>" . select_value($V, $_, $m, $ze);
        return "<table cellspacing='0'>$M</table>";
    }
    if (!$_) $_ = $c->selectLink($W, $m);
    if ($_ === null) {
        if (is_mail($W)) $_ = "mailto:$W";
        if (is_url($W)) $_ = $W;
    }
    $M = $c->editVal($W, $m);
    if ($M !== null) {
        if (!is_utf8($M)) $M = "\0"; elseif ($ze != "" && is_shortable($m)) $M = shorten_utf8($M, max(0, +$ze));
        else$M = h($M);
    }
    return $c->selectVal($M, $_, $m, $W);
}

function
is_mail($sb)
{
    $pa = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $lb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $qd = "$pa+(\\.$pa+)*@($lb?\\.)+$lb";
    return
        is_string($sb) && preg_match("(^$qd(,\\s*$qd)*\$)i", $sb);
}

function
is_url($me)
{
    $lb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    return
        preg_match("~^(https?)://($lb?\\.)+$lb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $me);
}

function
is_shortable($m)
{
    return
        preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $m["type"]);
}

function
count_rows($S, $Z, $w, $r)
{
    global $x;
    $K = " FROM " . table($S) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
    return ($w && ($x == "sql" || count($r) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $r) . ")$K" : "SELECT COUNT(*)" . ($w ? " FROM (SELECT 1$K GROUP BY " . implode(", ", $r) . ") x" : $K));
}

function
slow_query($K)
{
    global $c, $He, $k;
    $j = $c->database();
    $Be = $c->queryTimeout();
    $de = $k->slowQuery($K, $Be);
    if (!$de && support("kill") && is_object($i = connect()) && ($j == "" || $i->select_db($j))) {
        $xc = $i->result(connection_id());
        echo '<script', nonce(), '>
var timeout = setTimeout(function () {
	ajax(\'', js_escape(ME), 'script=kill\', function () {
	}, \'kill=', $xc, '&token=', $He, '\');
}, ', 1000 * $Be, ');
</script>
';
    } else$i = null;
    ob_flush();
    flush();
    $M = @get_key_vals(($de ? $de : $K), $i, false);
    if ($i) {
        echo
        script("clearTimeout(timeout);");
        ob_flush();
        flush();
    }
    return $M;
}

function
get_token()
{
    $Fd = rand(1, 1e6);
    return ($Fd ^ $_SESSION["token"]) . ":$Fd";
}

function
verify_token()
{
    list($He, $Fd) = explode(":", $_POST["token"]);
    return ($Fd ^ $_SESSION["token"]) == $He;
}

function
lzw_decompress($za)
{
    $jb = 256;
    $_a = 8;
    $Ka = array();
    $Md = 0;
    $Nd = 0;
    for ($s = 0; $s < strlen($za); $s++) {
        $Md = ($Md << 8) + ord($za[$s]);
        $Nd += 8;
        if ($Nd >= $_a) {
            $Nd -= $_a;
            $Ka[] = $Md >> $Nd;
            $Md &= (1 << $Nd) - 1;
            $jb++;
            if ($jb >> $_a) $_a++;
        }
    }
    $ib = range("\0", "\xFF");
    $M = "";
    foreach ($Ka
             as $s => $Ja) {
        $rb = $ib[$Ja];
        if (!isset($rb)) $rb = $jf . $jf[0];
        $M .= $rb;
        if ($s) $ib[] = $jf . $rb[0];
        $jf = $rb;
    }
    return $M;
}

function
on_help($Pa, $ce = 0)
{
    return
        script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Pa, $ce) }, onmouseout: helpMouseout});", "");
}

function
edit_form($b, $n, $N, $Xe)
{
    global $c, $x, $He, $l;
    $ue = $c->tableName(table_status1($b, true));
    page_header(($Xe ? lang(10) : lang(11)), $l, array("select" => array($b, $ue)), $ue);
    if ($N === false) echo "<p class='error'>" . lang(12) . "\n";
    echo '<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (!$n) echo "<p class='error'>" . lang(13) . "\n"; else {
        echo "<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");
        foreach ($n
                 as $E => $m) {
            echo "<tr><th>" . $c->fieldName($m);
            $fb = $_GET["set"][bracket_escape($E)];
            if ($fb === null) {
                $fb = $m["default"];
                if ($m["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $fb, $Id)) $fb = $Id[1];
            }
            $X = ($N !== null ? ($N[$E] != "" && $x == "sql" && preg_match("~enum|set~", $m["type"]) ? (is_array($N[$E]) ? array_sum($N[$E]) : +$N[$E]) : $N[$E]) : (!$Xe && $m["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $fb)));
            if (!$_POST["save"] && is_string($X)) $X = $c->editVal($X, $m);
            $q = ($_POST["save"] ? (string)$_POST["function"][$E] : ($Xe && preg_match('~^CURRENT_TIMESTAMP~i', $m["on_update"]) ? "now" : ($X === false ? null : ($X !== null ? '' : 'NULL'))));
            if (preg_match("~time~", $m["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $X)) {
                $X = "";
                $q = "now";
            }
            input($m, $X, $q);
            echo "\n";
        }
        if (!support("table")) echo "<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $c->editFunctions(array("null" => isset($_GET["select"])))) . "<td><input name='field_vals[]'>" . "\n";
        echo "</table>\n";
    }
    echo "<p>\n";
    if ($n) {
        echo "<input type='submit' value='" . lang(14) . "'>\n";
        if (!isset($_GET["select"])) {
            echo "<input type='submit' name='insert' value='" . ($Xe ? lang(15) : lang(16)) . "' title='Ctrl+Shift+Enter'>\n", ($Xe ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . lang(17) . "…', this); };") : "");
        }
    }
    echo($Xe ? "<input type='submit' name='delete' value='" . lang(18) . "'>" . confirm() . "\n" : ($_POST || !$n ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
    if (isset($_GET["select"])) hidden_fields(array("check" => (array)$_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]));
    echo '<input type="hidden" name="referer" value="', h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]), '">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="', $He, '">
</form>
';
}

if (isset($_GET["file"])) {
    if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: immutable");
    if ($_GET["file"] == "favicon.ico") {
        header("Content-Type: image/x-icon");
        echo
        lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
    } elseif ($_GET["file"] == "default.css") {
        header("Content-Type: text/css; charset=utf-8");
        echo
        lzw_decompress("\n1̇�ٌ�l7��B1�4vb0��fs���n2B�ѱ٘�n:�#(�b.\rDc)��a7E����l�ñ��i1̎s���-4��f�	��i7������Fé�vt2���!�r0���t~�U�'3M��W�B�'c�P�:6T\rc�A�zr_�WK�\r-�VNFS%~�c���&�\\^�r����u�ŎÞ�ً4'7k����Q��h�'g\rFB\ryT7SS�P�1=ǤcI��:�d��m>�S8L�J��t.M���	ϋ`'C����889�� �Q����2�#8А����6m����j��h�<�����9/��:�J�)ʂ�\0d>!\0Z��v�n��o(���k�7��s��>��!�R\"*nS�\0@P\"��(�#[���@g�o���zn�9k�8�n���1�I*��=�n������0�c(�;�à��!���*c��>Ύ�E7D�LJ��1����`�8(��3M��\"�39�?E�e=Ҭ�~������Ӹ7;�C����E\rd!)�a*�5ajo\0�#`�38�\0��]�e���2�	mk��e]���AZs�StZ�Z!)BR�G+�#Jv2(���c�4<�#sB�0���6YL\r�=���[�73��<�:��bx��J=	m_ ���f�l��t��I��H�3�x*���6`t6��%�U�L�eق�<�\0�AQ<P<:�#u/�:T\\>��-�xJ�͍QH\nj�L+j�z��7���`����\nk��'�N�vX>�C-T˩�����4*L�%Cj>7ߨ�ި���`���;y���q�r�3#��} :#n�\r�^�=C�Aܸ�Ǝ�s&8��K&��*0��t�S���=�[��:�\\]�E݌�/O�>^]�ø�<����gZ�V��q����� ��x\\������޺��\"J�\\î��##���D��x6��5x�������\rH�l ����b��r�7��6���j|����ۖ*�FAquvyO��WeM����D.F��:R�\$-����T!�DS`�8D�~��A`(�em�����T@O1@��X��\nLp�P�����m�yf��)	���GSEI���xC(s(a�?\$`tE�n��,�� \$a��U>,�В\$Z�kDm,G\0��\\��i��%ʹ� n��������g���b	y`��Ԇ�W� 䗗�_C��T\ni��H%�da��i�7�At�,��J�X4n����0o͹�9g\nzm�M%`�'I���О-���7:p�3p��Q�rED������b2]�PF����>e���3j\n�߰t!�?4f�tK;��\rΞи�!�o�u�?���Ph���0uIC}'~��2�v�Q���8)���7�DI�=��y&��ea�s*hɕjlA�(�\"�\\��m^i��M)��^�	|~�l��#!Y�f81RS����!���62P�C��l&���xd!�|��9�`�_OY�=��G�[E�-eL�CvT� )�@�j-5���pSg�.�G=���ZE��\$\0�цKj�U��\$���G'I�P��~�ځ� ;��hNێG%*�Rj�X[�XPf^��|��T!�*N��І�\rU��^q1V!��Uz,�I|7�7�r,���7���ľB���;�+���ߕ�A�p����^���~ؼW!3P�I8]��v�J��f�q�|,���9W�f`\0�q�A�wE���մ�F����T�QՑG���\$0Ǔʠ#�%By7r�i{e�Q���d���Ǉ �B4;ks(�0ݎ�=�1r)_<���;̹��S��r� &Y�,h,��iiك��b�̢A�� ��G��L��z2p(�������0�����L	��S����E���	<���}_#\\f��daʄ�K�3�Y|V+�l@�0`;���Lh���ޯj'������ƙ�Y�+��QZ-i���yv��I�5ړ0O|�P�]F܏�����\0���2�D9͢���n/χQس&��I^�=�l��qfI��= �]xqGR�F�e�7�)��9*�:B�b�>a�z�-���2.����b{��4#�����Uᓍ�L7-��v/;�5��u���H��&�#���j�`�G�8� �7p���ҠYC��~��:�@��EU�J��;v7v]�J'���q1��El��Іi�����/��{k<��֡M�po�}������ٞ,�dæ�_uӗ���p�u޽�����=���tn���	����~�Lx�����{k��߇���\rj~�P+���0�u�ow�yu\$��߷�\nd��m�Zd��8i`�=��g�<���ۓ��͈*+3j����܏<[�\0���/PͭB��r���`�`�#x�+B?#�܏^;Ob\r����4��\n���0\n����0�\\�0>��P�@���2�l��j�O����(_�<�W\$�g���G�tא@�l.�h�Siƾ��PH�\n�J����LD�");
    } elseif ($_GET["file"] == "functions.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
        lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO��er�x�9�*ź��n3�\rщv�C��`���2G%�Y�����1��f���Ȃl��1�\ny�*pC\r\$�n�T��3=\\�r9O\"�	��l<�\r�\\��I,�s\nA��eh+M�!�q0��f�`(�N{c��+w���Y��p٧3�3��+I��j�����k��n�q���zi#^r�����3���[��o;��(��6�#�Ґ��\":cz>ߣC2v�CX�<�P��c*5\n���/�P97�|F��c0�����!���!���!��\nZ%�ć#CH�!��r8�\$���,�Rܔ2���^0��@�2��(�88P/��݄�\\�\$La\\�;c�H��HX���\nʃt���8A<�sZ�*�;I��3��@�2<���!A8G<�j�-K�({*\r��a1���N4Tc\"\\�!=1^���M9O�:�;j��\r�X��L#H�7�#Tݪ/-���p�;�B \n�2!���t]apΎ��\0R�C�v�M�I,\r���\0Hv��?kT�4����uٱ�;&���+&���\r�X���bu4ݡi88�2B�/⃖4���N8A�A)52������2��s�8�5���p�WC@�:�t�㾴�e��h\"#8_��cp^��I]OH��:zd�3g�(���Ök��\\6����2�ږ��i��7���]\r�xO�n�p�<��p�Q�U�n��|@���#G3��8bA��6�2�67%#�\\8\r��2�c\r�ݟk��.(�	��-�J;��� ��L�� ���W��㧓ѥɤ����n��ҧ���M��9ZНs]�z����y^[��4-�U\0ta��62^��.`���.C�j�[ᄠ% Q\0`d�M8�����\$O0`4���\n\0a\rA�<�@����\r!�:�BA�9�?h>�Ǻ��~̌�6Ȉh�=�-�A7X��և\\�\r��Q<蚧q�'!XΓ2�T �!�D\r��,K�\"�%�H�qR\r�̠��C =�������<c�\n#<�5�M� �E��y�������o\"�cJKL2�&��eR��W�AΐTw�ё;�J���\\`)5��ޜB�qhT3��R	�'\r+\":�����.��ZM'|�et:3%L��#f!�h�׀e����+ļ�N�	��_�CX��G�1��i-ãz�\$�oK@O@T�=&�0�\$	�DA�����D�SJ�x9ׁFȈml��p�Gխ�T�6Rf�@�a�\rs�R�Fgih]��f�.�7+�<nhh�* �SH	P]� :Ғ��a\"�����2�&R�)�B�Pʙ�H/��f {r|�0^�hCA�0�@�M���2�B�@��z�U���O���Cpp��\\�L�%�𛄒y��odå���p3���7E����A\\���K��Xn��i.�Z�� ���s��G�m^�tI�Y�J��ٱ�G1��R��D��c���6�tMih��9��9g��q�RL��Mj-TQ�6i�G_!�.�h�v��cN�����^��0w@n|���V�ܫ�AЭ��3�[��]�	s7�G�P@ :�1т�b� ��ݟ���w�(i��:��z\\��;���A�PU T^�]9�`UX+U��Q+��b���*ϔs������[�ۉxk�F*�ݧ_w.��6~�b��mK�sI�MK�}�ҥ���eHɲ�d�*md�l�Q��eH�2�ԍL���a҂�=��s�P�aM\"ap��:<��GB�\r2Ytx&L}}��A�ԱN�GЬza��D4�t�4Q�vS�ùS\r�;U��������~�pB��{���,���O��t;�J��ZC,&Y�:Y\"�#�����t:\n�h8r����n���h>��>Z��`&�a�pY+�x�U��A�<?�PxWա�W�	i��.�\r`�\$,���Ҿ��V�]�Zr���H��5�f\\�-KƩ�v��Z��A��(�{3�o��l.��J��.�\\t2�;���2\0��>c+�|��*;-0�n��[�t@�ڕ��=cQ\n.z���wC&��@���F�����'cBS7_*rsѨ�?j�3@����!�.@7�s�]Ӫ�L�΁G��@��_�q���&u���t�\nՎ�L�E�T��}gG����w�o�(*�����A�-�����3�mk�����פ��t��S���(�d��A�~�x\n����k�ϣ:D��+�� g��h14 ��\n.��d꫖������AlY��j���jJ���PN+b� D�j������D��P���LQ`Of��@�}�(���6�^nB�4�`�e��\n��	�trp!�lV�'�}b�*�r%|\nr\r#���@w��-�T.Vv�8��\nmF�/�p��`�Y0�����P\r8�Y\r��ݤ�	�Q���%E�/@]\0��{@�Q���\0bR M\r��'|��%0SDr����f/����b:ܭ�����%߀�3H�x\0�l\0���	��W��%�\n�8\r\0}�D���1d#�x��.�jEoHrǢlb���%t�4�p���%�4���k�z2\r�`�W@�%\rJ�1��X���1�D6!��*��{4<E��k.m�4����\r\n�^i��� �!n��!2\$������(�f������k>����N��5\$���2T�,�LĂ� � Z@��*�`^P�P%5%�t�H�W��on���E#f���<�2@K:�o����Ϧ�-��2\\Wi+f�&��g&�n�L�'e�|����nK�2�rڶ�p�*.�n��������*�+�t�Bg* ��Q�1+)1h���^�`Q#�؎�n*h���v�B��\0\\F\n�W�r f\$�=4\$G4ed�b�:J^!�0��_���%2��6�.F���Һ�EQ�����dts\"�����B(�`�\r���c�R����V����X��:R�*2E*s�\$��+�:bXl��tb��-�S>��-�d�=��\$S�\$�2�ʁ7�j�\"[́\"��]�[6��SE_>�q.\$@z`�;�4�3ʼ�CS�*�[���{DO�ުCJj峚P�:'���ȕ QEӖ�`%r��7��G+hW4E*��#TuFj�\n�e�D�^�s��r.��Rk��z@��@���D�`C�V!C���\0��ۊ)3<��Q4@�3SP��ZB�5F�L�~G�5���:���5\$X���}ƞf���I���3S8�\0XԂtd�<\nbtN� Q�;\r��H��P�\0��&\n���\$V�\r:�\0]V5gV���D`�N1:�SS4Q�4�N��5u�5�`x	�<5_FH���}7��)�SV��Ğ#�|��< ռ�˰���\\��-�z2�\0�#�WJU6kv���#��\r�췐����U��i��_��^�UVJ|Y.��ɛ\0u,�������_UQD#�ZJu�Xt��_�&JO,Du`N\r5��`�}ZQM^m�P�G[��a�b�N䞮��re�\n��%�4��o_(�^�q@Y6t;I\nGSM�3��^SAYH�hB��5�fN?NjWU�J����֯Yֳke\"\\B1�؅0� �en���*<�O`S�L�\n��.g�5Zj�\0R\$�h��n�[�\\���r���,�4����cP�p�q@R�rw>�wCK��t��}5_uvh��`/����\$�J)�R�2Du73�d\r�;��w���H�I_\"4�r�����Ͽ+�&0>�_-eqeD��V��n��f�h��\"Z����Z�W�6\\L���ke&�~������i\$ϰ�Mr�i*�����\0�.Q,��8\r���\$׭K��Y� �io�e%t�2�\0�J��~��/I/.�e��n�~x!�8��|f�h�ۄ-H���&�/��o�����.K� �^j��t��>('L\r��HsK1�e�\0��\$&3�\0�in3� o�6�ж�����9�j������1�(b.�vC�ݎ8���:wi��\"�^w�Q����z�o~�/��Ғ���`Y2��D�V����/k�8��7Z�H����]2k2r���ϯh�=�T��]O&�\0�M\0�[8��Ȯ���8&L�Vm�v���j�ך�F��\\��	���&s��Q� \\\"�b��	��\rBs�Iw�	�Y��N �7�C/*����\n\n�H�[����*A���TE�VP.UZ(tz/}\n2��y�S���,#�3�i�~W@yCC\nKT��1\"@|�zC\$��_CZjzHB�LV�,K����O���P�@X���������;D�WZ�W�a���\0ފ�CG8�R �	�\n������P�A��&������,�pfV|@N�b�\$�[�I����������Z�@Zd\\\"�|��+�ۮ��tz�o\$�\0[����y�E���ə�bhU1��,�r\$�o8D���F��V&ځ5�h}��N�ͳ&�絕ef�ǙY��:�^z�VPu	W�Z\"r�:�h�w��h#1��O���K�hq`妄����v|�˧:wD�j�(W�������碌�?�;|Z��%�%ڡ�r@[����B�&������#���ُ��:)��Y6����&��	@�	���I��!����� ���2M���O;���W��)��C��FZ�p!��a��*F�b�I��;���#Ĥ9����S�/S�A�`z�L*�8�+��N���-�M���-kd���Li�J�·�Jn��b��>,�V�SP�8��>�w��\"E.��Rz`��u_����E\\��ɫ�3P��ӥs]���goVS���\n��	*�\r��7)�ʄ�m�PW�UՀ��ǰ���f��ܓi�ƅkЌ\r�('W`�Bd�/h*�A�l�M��_\n�������O��T�5�&A�2é`��\\R�E\"_�_��.7�M�6d;�<?��)(;���}K�[�����Z?��yI ��1p�bu\0�������{��\ri�s�QQ�Y�2��\rה0\0X�\"@q��uMb��uJ�6�NG���^��wF/t���#P�p��!7������囜!û�^V��M�!(⩀8֝�=�\0�@���80N�Sཾ�Q�_T��ĥ�qSz\"�&h�\0R.\0hZ�fx���F9�Q(�b�=�D&xs=X�bu�@o�w�d�5���P�1P>k��H�D6/ڿ�q랼��3�7TЬK�~54�	�t#�M�\rc�tx�g��T��X\r�2\$�<0�y}*��Cbi�^��L�7	�b�o����x71� b�XS`O���0)���\"�/��=Ȭ �l��Q�p�-�!��{��������a��ȕ9bAg�2,1�zf�k��j�h/o(�.4�\r���Tz&nw���7 X!����@,�<�	��`\"@:��7�CX\\	 \$1H\n=ě�O5��&�v�*(	�tH��#�\n�_X/8�k~+t���O&<v��_Yh��.��Me�Hxp�I�a��0�M\nh�`r'B���h�n8q��!	�֠eu��]^TW����d9{��H,㗂8��L�a�,!\0;��B#�#��`�)�����	ńa�Ee�ڑ�/M�P�	�l���a`	�sⲅ<(D\n���9{06�ƈ;A8��5!	���Z[T� hV���ܻ��U@�n`�V�p��h(Rb4�V�Ɖ����Rp��Ҕ\$����D3O����\$�����aQ��0xb�H`����LÔ8i��oC�����#6�x�)XH�!`�������B�%w���o\nx̀h��H���r� ʼc��mJH�LU����e1l`�(�\$\"�h�J�rv���TP�����1uHA\0��H2@(ʡU�\"�Q�@qg]l\"�%���*�\0W�j[� ���e�4���P��N����5\$H\r��IP��'@:\0�\"#t^�D��0���>�(��h� '��F,sZJ��An�#�h��X��.q��Yob�����2��?j��B�I��ߣ��������0�a�(�`Z�C����r��HSQ��\\��W	��XZ��|�E@���TԝŖq�DD:_y��İ��B�~�xP�--e��_�u�|2(�G,��-rR�Kx���d���hH�A|���w�|P�!ǉґ䎬}�T���<��,1��v�g*���z�^������_pi {��G����	LaJJC�T%N1��I:V@Z��%ɂ*�|@NNxL��L�zd \$8b#�!2=cۍ�QD��@�\0�J�dzp��\$A�|ya4)��s%!�BI�Q]d�G�6&E\$��H\$Rj\0���ܗGi\$إ�9ņY��@ʴ0�6Ħ��X�ܞ1&L��&2�	E^��a8�j�#�DEu�\$uT�*R�#&��P2�e��K��'�E%┡�YW�J��	����O`�ʕ��^l+��`�	R�1u�&F���Z[)]J�Z�E��`��FN.\r�=�� ��\0�O~���M,��FAT�b�h�z0��`-bl�\n�ǅZ�'�*I�n�\$�[�,8D��n��`����I0u�0��EJ鸆Xc�e�2P�� b��]���5:겓�'xT	�'bO�Y��V>&��A�.Pp�ŭ\${)9\"i�c���Ǚ�L� P�K�T��9���0wZ\"b	�)���R��&�ɢ���&�X+���s%[�~&aF��i.:�K�a5@���q���pG��hĺn�0y�H,W>�J�!���&�2Y���lAp����-3�]���2C�MZ����H�o�d�1Dl�uS\"��M�Tz\$�h\\c����w<�cO3?z���p%@\0�4\n�Z�ӗ���f*\r���|�ل;3�M�Rm�� �w�X���.Y�L���]Wg]��\r胜1@U8��e3U����D�	z�'���&��#hu�a1C�0�{ph͔\n?��YK�B���Y��A9�,�F��w�");
    } elseif ($_GET["file"] == "jush.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
        lzw_decompress('');
    } else {
        header("Content-Type: image/gif");
        switch ($_GET["file"]) {
            case"plus.gif":
                echo '';
                break;
            case"cross.gif":
                echo '';
                break;
            case"up.gif":
                echo '';
                break;
            case"down.gif":
                echo '';
                break;
            case"arrow.gif":
                echo '';
                break;
        }
    }
    exit;
}
if ($_GET["script"] == "version") {
    $p = file_open_lock(get_temp_dir() . "/adminer.version");
    if ($p) file_write_unlock($p, serialize(array("signature" => $_POST["signature"], "version" => $_POST["version"])));
    exit;
}
global $c, $h, $k, $mb, $pb, $xb, $l, $Wb, $Zb, $aa, $qc, $x, $a, $Ac, $bd, $rd, $ne, $dc, $He, $Le, $Pe, $We, $ba;
if (!$_SERVER["REQUEST_URI"]) $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
$aa = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
    session_cache_limiter("");
    session_name("adminer_sid");
    $od = array(0, preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]), "", $aa);
    if (version_compare(PHP_VERSION, '5.2.0') >= 0) $od[] = true;
    call_user_func_array('session_set_cookie_params', $od);
    session_start();
}
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE), $Kb);
if (get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
$Ac = array('en' => 'English', 'ar' => 'العربية', 'bg' => 'Български', 'bn' => 'বাংলা', 'bs' => 'Bosanski', 'ca' => 'Català', 'cs' => 'Čeština', 'da' => 'Dansk', 'de' => 'Deutsch', 'el' => 'Ελληνικά', 'es' => 'Español', 'et' => 'Eesti', 'fa' => 'فارسی', 'fi' => 'Suomi', 'fr' => 'Français', 'gl' => 'Galego', 'he' => 'עברית', 'hu' => 'Magyar', 'id' => 'Bahasa Indonesia', 'it' => 'Italiano', 'ja' => '日本語', 'ka' => 'ქართული', 'ko' => '한국어', 'lt' => 'Lietuvių', 'ms' => 'Bahasa Melayu', 'nl' => 'Nederlands', 'no' => 'Norsk', 'pl' => 'Polski', 'pt' => 'Português', 'pt-br' => 'Português (Brazil)', 'ro' => 'Limba Română', 'ru' => 'Русский', 'sk' => 'Slovenčina', 'sl' => 'Slovenski', 'sr' => 'Српски', 'ta' => 'த‌மிழ்', 'th' => 'ภาษาไทย', 'tr' => 'Türkçe', 'uk' => 'Українська', 'vi' => 'Tiếng Việt', 'zh' => '简体中文', 'zh-tw' => '繁體中文',);
function
get_lang()
{
    global $a;
    return $a;
}

function
lang($u, $F = null)
{
    if (is_string($u)) {
        $ud = array_search($u, get_translations("en"));
        if ($ud !== false) $u = $ud;
    }
    global $a, $Le;
    $Ke = ($Le[$u] ? $Le[$u] : $u);
    if (is_array($Ke)) {
        $ud = ($F == 1 ? 0 : ($a == 'cs' || $a == 'sk' ? ($F && $F < 5 ? 1 : 2) : ($a == 'fr' ? (!$F ? 0 : 1) : ($a == 'pl' ? ($F % 10 > 1 && $F % 10 < 5 && $F / 10 % 10 != 1 ? 1 : 2) : ($a == 'sl' ? ($F % 100 == 1 ? 0 : ($F % 100 == 2 ? 1 : ($F % 100 == 3 || $F % 100 == 4 ? 2 : 3))) : ($a == 'lt' ? ($F % 10 == 1 && $F % 100 != 11 ? 0 : ($F % 10 > 1 && $F / 10 % 10 != 1 ? 1 : 2)) : ($a == 'bs' || $a == 'ru' || $a == 'sr' || $a == 'uk' ? ($F % 10 == 1 && $F % 100 != 11 ? 0 : ($F % 10 > 1 && $F % 10 < 5 && $F / 10 % 10 != 1 ? 1 : 2)) : 1)))))));
        $Ke = $Ke[$ud];
    }
    $na = func_get_args();
    array_shift($na);
    $Tb = str_replace("%d", "%s", $Ke);
    if ($Tb != $Ke) $na[0] = format_number($F);
    return
        vsprintf($Tb, $na);
}

function
switch_lang()
{
    global $a, $Ac;
    echo "<form action='' method='post'>\n<div id='lang'>", lang(19) . ": " . html_select("lang", $Ac, $a, "this.form.submit();"), " <input type='submit' value='" . lang(20) . "' class='hidden'>\n", "<input type='hidden' name='token' value='" . get_token() . "'>\n";
    echo "</div>\n</form>\n";
}

if (isset($_POST["lang"]) && verify_token()) {
    cookie("adminer_lang", $_POST["lang"]);
    $_SESSION["lang"] = $_POST["lang"];
    $_SESSION["translations"] = array();
    redirect(remove_from_uri());
}
$a = "en";
if (isset($Ac[$_COOKIE["adminer_lang"]])) {
    cookie("adminer_lang", $_COOKIE["adminer_lang"]);
    $a = $_COOKIE["adminer_lang"];
} elseif (isset($Ac[$_SESSION["lang"]])) $a = $_SESSION["lang"];
else {
    $ha = array();
    preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $Lc, PREG_SET_ORDER);
    foreach ($Lc
             as $B) $ha[$B[1]] = (isset($B[3]) ? $B[3] : 1);
    arsort($ha);
    foreach ($ha
             as $y => $Bd) {
        if (isset($Ac[$y])) {
            $a = $y;
            break;
        }
        $y = preg_replace('~-.*~', '', $y);
        if (!isset($ha[$y]) && isset($Ac[$y])) {
            $a = $y;
            break;
        }
    }
}
$Le = $_SESSION["translations"];
if ($_SESSION["translations_version"] != 2496664430) {
    $Le = array();
    $_SESSION["translations_version"] = 2496664430;
}
function
get_translations($_c)
{
    switch ($_c) {
        case"en":
            $g = "A9D�y�@s:�G�(�ff�����	��:�S���a2\"1�..L'�I��m�#�s,�K��OP#I�@%9��i4�o2ύ���,9�%�P�b2��a��r\n2�NC�(�r4��1C`(�:Eb�9A�i:�&㙔�y��F��Y��\r�\n� 8Z�S=\$A����`�=�܌���0�\n��dF�	��n:Zΰ)��Q���mw����O��mfpQ�΂��q��a�į�#q��w7S�X3���=�O��ztR-�<����i��gKG4�n����r&r�\$-��Ӊ�����KX�9,�8�7�o�ʻ/;��\"�(#��;��#�7�Ct6�\r�cܦ��*�2��𰡉�<��HKG\nH<��X!hH���P2�c�9���4/�8���0(��#b��h���lR�B36���5��:.2t�>��Gjt�0��T:?Or���B2��2|ŵT+���	C�	@t&��Ц)�B��Q�\"��6��\$E=LJk6��Cc�ñ0Z7��0ص�rX�ƎQ΂�\"�ލE#p򍯃��1�#��:��Z݅���������7��cY���Y���j���	[��d�Ϸʤ���0�i�)�B3.7�op\\OMc/*\$�:`�[�@�X�=�hC�zP*1n�|3<�����q���\\����@\$cB3��:�t�㾄\$c����{��褾7�}���x�!�Ih�ʞ8\r(�l��b�kD�(��	R���?�����ay���9������ך8��ok���*\0|\$�H��:j���B#@�\0�8Ld��DUJ�p������d�k��C&?�2�N;�֯_ЎY ��#�ΎX�ێڛDJw�ч�C�����8��Y<����R!�z(�T���\0�\$\n�;ů�\0P�)�_�3D�m{~�k2H�>�΁ёJ)�ę�U���z�\\�=��a�U�\$�����ނ���7\$@�\nS\r)9��v��a��+�TK	q0\\���<Uq#�\$�2➴	�}D]�����1�0�\$�B]�	K)�Q\0��|@C��*\$�5��V�^��dy���@�L�X�����  Uᅅ�\"j���z3�����a	�e��&�k��aN&�ƒ�A���#�x�A��B�Q	����&H�0T}�'V^#\"P���/�:LY>RQ��S:�ԷPR�2�b8��t�,'�\\�n���%	�˅.�f�p9E9�£���W3n`3�\\k�a���GM�\r�l4�e�^\n�%э׮\0�0-��s�4�	�F36]��7�\n�\nFb��\\�&<&`���B\\O9)���3�\ra�Q�6H��X�y\n��ڢ��;��.�ه�	�X���o�=�2AJ��ѥ�Dw4N	VH��I�D��A���ݒ�z��&(Y� .`(**Va�}�%�e����O	j&�2�e��c�\0���";
            break;
        case"ar":
            $g = "�C�P���l*�\r�,&\n�A���(J.��0Se\\�\r��b�@�0�,\nQ,l)���µ���A��j_1�C�M��e��S�\ng@�Og���X�DM�)��0��cA��n8�e*y#au4�� �Ir*;rS�U�dJ	}���*z�U�@��X;ai1l(n������[�y�d�u'c(��oF����e3�Nb���p2N�S��ӳ:LZ�z�P�\\b�u�.�[�Q`u	!��Jy��&2��(gT��SњM�x�5g5�K�K�¦����0ʀ(�7\rm8�7(�9\r�f\"7�^��pL\n7A�*�BP��<7cp�4���Y�+dHB&���O��̤��\\�<i���H��2�lk4�����ﲠ�&ŊH�Ą,j�?&�\\����>����%�h�=�î�(���;\"�3���]6:qd},�Lij�&�Z��!P�#����M8�xH���iA��Zԏ<dR���d4ƶ�h�P�&�|\\l����B�LN����|kT%ȋ\r0 ��ڃ��b�[+e�~�-hJ`��&ʆT��L���3sT-����6˩hT��\$	К&�B��\rCP^6��x�0ރ��\$2qm[�\n�:�G#��6L�@0�M(�3�c�2��L����2�3B�+�	�*\r�@�0���@:�è�1�C��:��\0�7��P�6��L0���g�\0@6�C�vaJ�����@!�b���*��J�:�h]/-�lZj�o!/��'6\\���3k��5��m��YA1��٭c�\0ٌА��a\0�2h�t\r�q>2@�\0x0�8H��C@�:�t��D<FA#8^2��x��QZ�|(:=C8x�!��� S��.RI�F*�2�؉��EI\rm�����9N���0�m��������0��4�#&���//��|�?��}/�OW��p�>�Ax\")��\$���k�k���ޡ�M�oP&ա��iCHt5(����\ny�'�]�RR~Ӂ�)<2��I3\n��҆�� 湘�#J3�P%@�����*e�͗3d��;7����A\0c}0(4��؉�0ȱ�R����[T����3 �Pp\r��3�`�ki-�T�Ƃ�VH��h��Cwrm\rA�5���UHt6f���5��w��=~���[Q�{��f���I6\\�A�f��p��a�h3����9(�o�hha�3��A���a����oElY<\$����i ���s�r�ܤkq�s��	S�B�\$���g�\0d\r*����� ��6l\$8�Se�2\r��8��-� cfs�*IIdlI���I���\0@xS\n�,�����1�h��2���D �؜B��D�tx`@�,宠Œ�MM��x��B�Mrx��f�@P3��e�Cn��( r��b\0�B` �0�(��P�A�@��\r\$Z\0�DmD��i6�k��H��i�:�X����ōx;��U�uo_�Ł_	���RtS�/!�H���	�C��6�CkC�h�?�CC�A�32h2L�5\\\r�\rL�~B�F��	���z��?3��-�{ŽE#�Ò6�[u:���'@m]�Z�<lS�F�,Д\n~�&t�H.VA�p@��L�����V�JA\" 	M���L�`o�!��Srp@Vt��RS*�:*NmX������<S��\n�\"�rxS����,~��Ow�'�&˅��&�`U����i	�;VRaQrU�z�U�� ";
            break;
        case"bg":
            $g = "�P�\r�E�@4�!Awh�Z(&��~\n��fa��N�`���D��4���\"�]4\r;Ae2��a�������.a���rp��@ד�|.W.X4��FP�����\$�hR�s���}@�Зp�Д�B�4�sE�΢7f�&E�,��i�X\nFC1��l7c��MEo)_G����_<�Gӭ}���,k놊qPX�}F�+9���7i��Z贚i�Q��_a���Z��*�n^���S��9���Y�V��~�]�X\\R�6���}�j�}	�l�4�v��=��3	�\0�@D|�¤���[�����^]#�s.�3d\0*��X�7��p@2�C��9(� �9�#�2�pA��tcƣ�n9G�8�:�p�4��3����Jn��<���(�5\n��Kz\0��+��+0�KX��e�>I�J���L�H��/�h�C��>�B��\"��w=KK��ʦ�\$h���i�\n��4�����b��M�R&��kT��`HKP��\"���H�&!hH�A�>Q/�H�Bj˶�4�A㢨����{:ؒu�hJ��r��)|�=�)�-	X�(Z6�#H؏����Q,|��R�x�C0�),/��S������ꪮ��J�Qw��uMT>pS�Q4�b�&\$���\n%v��2�N\n19� %-���L.��1y��ty�l7��,�,����� P�:Mͬ�0�6�Q��^�%\rr���ѮN\\O���6�!�[��_�G\$��(��/�(�B�����f�05��@�/ށ����P�S�:��e����)���/:���M;~�:�n�Gm��U;�6�!����,i�%���bW��P��u���(jb]�\$rh!��[a��� l���N�>!%�����;I�x��;������	;0�\n�@���4p:��p�# �4��F�1�28���\r����\"\r�:\0��x/�,��@.Ea��P^Ha� 7�D��:�o����I@O4���\0T؛�&@��(sH�I��A��͑G�J��lh�ܞ%��뒣�\$Dԝ��9�'���?��\0 ��\"@��ߊ,�pV�T��R:I�Ÿ4�6H����� �g�Ԝ��X�G�V\"mɻqs)񠙳JB⚄jG��l�b1�We\$�'tiMQ�!��2�J�Y|���H �6\0č�(|��6�UBC2DH�:�0�C�s��V���߄�\r!�4	������?p��lg0᰹<U�~M+<��2brbl=_2,Z4�w�:\n (rpT�Y�M&���\nK�.WǕ.��K�����@��r\r!�qP�-��+���F٘��[:H�K�\$�����]PQ1m�D��QB4���9�	MN�4��8ZAO�wEj�;����k��W#J����ģ�(s������\$�֦�M^n�J�CJ46����V��=.\"@޵׌�bk���a����=܂XR���'�n� |a�62�J�P�[0)r↬�ld��V�b��)�kd�M��j�Hi!RN\r�Ε�q��;��ߐ3�O�ʮ�2��c��#�7���3i�X\nE�;�p�H�kn�jK�x�ָ]Np \naD&r�ZɡƱ�*OT	'\n��)I�d6v\$Ћ�{i�0�+�轒&��Xv���j���lvJ�viS�Cj��#�Q��ݬ2c]�SX%E���],{0e�X1\"��l7\r�f���,��T6xY}:dř��d��F3Q,�;�.�np�\0���ZbJ}8re��� A\0U\n���d��z�[E|f�g)t�F�cn�<�N�pX�F|��ֺ�D�\\�4�ә|�K%�<�v段n�92U�1�5&_���>&�����n6��9���W�qA� �UU�X#�6�:`�k�h��P��G�� ��bO]��/\rE����ЉA�Imy���s���.�x�3��.Э��ڟ��y֯R�gr>&��ɟy�g�R��o���o!s+���٦�Ў4�Xr�����V榻�t�r׉+L��ɩ8";
            break;
        case"bn":
            $g = "�S)\nt]\0_� 	XD)L��@�4l5���BQp�� 9��\n��\0��,��h�SE�0�b�a%�. �H�\0��.b��2n��D�e*�D��M���,OJÐ��v����х\$:IK��g5U4�L�	Nd!u>�&������a\\�@'Jx��S���4�P�D�����z�.S��E<�OS���kb�O�af�hb�\0�B���r��)����Q��W��E�{K��PP~�9\\��l*�_W	��7��ɼ� 4N�Q�� 8�'cI��g2��O9��d0�<�CA��:#ܺ�%3��5�!n�nJ�mk����,q���@ᭋ�(n+L�9�x���k�I��2�L\0I��#Vܦ�#`�������B��4��:�� �,X���2����,(_)��7*�\n�p���p@2�C��9.�#�\0�ˋ�7�ct��.A�>����7cH�B@����G�CwF0;IF���~�#�5@��RS�z+	,��;1�O#(��w0��c��\n���MYL/q���Bب�hm^0�\n���L��ѥ*�Sђ\n^SY�͟���iNQ�]�N0l*�#c\"ܻH>��U9v��:��@��<� S���\\�bѶr�8�ȊCe\"��U��+�<b�H�ºE��9W��M���[�����vD�@q^`���j��-Œ�iW�-p ?H�6�%K���P-���-�p��oD��S��c���9+n�W�m�y[Z���j��(�:�k�≆�SE�^{�;j|6S4�@�\$Bh�\nb�:�h\\-�\\��.�Hy/��J��\"��k�`�9N�0�O �3�d�2�*��'�aae��XSWW�*\r�8�0���@:Ѓ��1�#��:��\0�7��`�>c��0���{�x�&��P9�4J�� dB�b��#6��Z�\"\nj�UQ�rV���s/\rx�,S�)�c� �O��q\n�:�\0�.6�b�`T<)��d�T*M2>0ܛ�cP�2&�@	�u!�� ��p`�����pa���8&���(n�C��\r�>���:\$��xa��ۑ6�m��7lGS�&�E�wo-�������+j	��0�_�N	��9���z#�s�u(�]Hdо��g\ra�9�p��x��<EQ\$ąT*������C��\r�\$:E�����?��uIbCY�\r!��&Ǉ	�s�c��/GU��*�b%E���J��X���3��eCA�!�*�p@�k�G�8&�<�Z�!�?����zI�=����\$�U�\0�\"e`i!�9�����3��EF?�\$���:&��\0���%�M�#C\r�J���&�)�\$Xȑ�-8�KɌj�Ȭ|�9�=g���U�xt>G���y@ޘw��\$�7�qV%+Y�pM��.��1a�mˤ�*�p|�x�0亃��a�X���\r��'�1�@�\n{�+�D�D��*TV	Yd��¢��\0�]X�\n��m,}j�G��V���aͺ�[)��ow,�\n+QN�٬�p�\"ala؎��<UR�H�y;��2��y��s�2���'RC�񗁙7�G&!u`MA���)�Q*��Q*M(�8(QP \n<)�Bx*�)�~��Ԑ�z#��M�@\\�]��;�Σ�˳�� �9�df\"� f��(�c}������ʐ��1U�0�\0f����C�(��]A�TT�r�i M��8*u`З!D\\��%\0��=D�J��b��-�6\\5HܮT~A&�ļ���:Yhn?��8d��2r�J3��K�KX�G��+һ:�Zz�!�\0Sc����{\\���,��s`F�E�7F]�\r!�5���C��4�X�@��4�.���A/+��\n�P#�p�aU�I��8�\\�b0���|AJN�m1av�����R��l��Y ]bB[nd_:�W��t���D�b6Y⟰3��[������}s5\n,�����di�I�`��DGEJ����!o�ov1���#��TlV\0��z� r ��f9�3�0R�S����bcf]A�7�C��\0W�QYaZ��Q \"1�f�3��o��e�(U����Y�֭vJ��l=��-�ʂ�\$2��O�Q�J�M�_��B�W4�붇�������)2�¸��6�i�s��I�*֛�|���\0";
            break;
        case"bs":
            $g = "D0�\r����e��L�S���?	E�34S6MƨA��t7��p�tp@u9���x�N0���V\"d7����dp���؈�L�A�H�a)̅.�RL��	�p7���L�X\nFC1��l7AG���n7���(U�l�����b��eēѴ�>4����)�y��FY��\n,�΢A�f �-�����e3�Nw�|��H�\r�]�ŧ��43�X�ݣw��A!�D��6e�o7�Y>9���q�\$���iM�pV�tb�q\$�٤�\n%���LIT�k���)�乪\r��ӄ\nh@����n�@�D2�8�9�#|&�\n�������:����#�`&>n���!���2��`�,S&b-#��>C���mh�	�ʊ�B�h�B��5(���F�p�� ���\$� @1&#�.���1��\0ԐI���A j�����S�����5�8ȎI+����B:ڇq��5�l<j�/��\"��sD7�+�'��x��J�J�LH�N+�������:���3MӪZ���+�]4Su�G[SJ�r��jô�����YV�\nWbՈ8@�YU�Zc\rB\$	К&�B��� \\6��p�<�Ⱥ��T��M�	6Fl�4,�3��ܿ���O�r��7��j4<���1�mP�3�b7��(�/��(0Ϫ+��̌0�:��@���p����b��#\r�IU��\r6���'a\0̹���\\*�#+ң\r�k-3��W��I<(�ɗ?� �B��� #C&3��:����xￅ���9˘���zp����^�Z>����^0��p�0�(��RV��h�I)96�?M�؛Q���Q�c��/B����{�9��������+�\\?BP�)��6�\r;7��1�q�Ѭ��%a�-��*��\\&�vd6��k�����9=#[6�H+�#�p���O�w4�x�>���b^!�ج�0Ƙ�%�����_CA[�07xs��wd���pR\nH	�������#A��\0�\n;Y#�Ī�x�A���\rĸ!�b�ܣ�4f�Ӛ�b\\á�6����\0�K��f���3�jGI�;7	6�(�睛ep�ц���\r�v��/sf�����/�C	C	(Y��2�#�s��(Q�����A'D��A�OL ~\r�Ӽ�Pd+<�T<���R�p�7%�e̘q��Y�c��[3����1��W-�[�5)�ɔ�A�O\naQ|D0֦��mZ�x��¸Ң~\rg���fMe@ Dpиf���1\n!�\n�b��ʙ�3�4��6�O�I%�y�%��Q	�8��J@B0T�i/\$5e,�L�F090�r���&\r!��\"G��!tf���NE�@Ę���Bs��d9	l��h�C�0K��0�f��tQk6�R	O��@Qkl!�0�\n�)�4I�,�#:�9�\0��C_1(�p5�P��h8A-�W�2\\�䑔���,���lꓬx����g9m�g��J9�k�F��*��0����fG�S�;�2v���KLI�.��0���,'�m+��*�]1E\r��DB�d՜H�*�ĴCm0Qh�l�Ħ�02E펗��.�d��Q3׃)b,��`(\"P*�o�!;F*�H�g_��Xfl�\$�l�5\nW}&�R�!�\0";
            break;
        case"ca":
            $g = "E9�j���e3�NC�P�\\33A�D�i��s9�LF�(��d5M�C	�@e6Ɠ���r����d�`g�I�hp��L�9��Q*�K��5L� ��S,�W-��\r��<�e4�&\"�P�b2��a��r\n1e��y��g4��&�Q:�h4�\rC�� �M���Xa����+�����\\>R��LK&��v������3��é�pt��0Y\$l�1\"P� ���d��\$�Ě`o9>U��^y�==��\n)�n�+Oo���M|���*��u���Nr9]x�&�����:��*!���p�\r#{\$��h�����h��nx8���	�c��C\"� P�2�(�2+��¡\0�����B�(8�<�H�4�cJhŠ�2a�o�4�\rZ�0����˴�@ʡ9�(�C�p�S\$�\n0����^s�c��(�1�؃��zR6\r�x�	㒌�&FZ�Kb�\$��9I��d|���/�e��C� P����qS\$	�C\"(��2�N�;U��Lc��S�(�PTR@\\���\\�U��_S��OO�U\rF9�)+ \$	К&�B��� ^6��x�0݃�KXUz�BP���MJ���x�3DR�b)��p�8���,�l��7���\$Q�''�PAB��X�C�<3�+ˌ�M)��:�@��8x���)�8��C \\a��Y�-��.�k8\n,�����a���5��4��\0�2eI~?�#*2L&�C(3��:����xﻅ��.�8^��:��A�xDpPۼ�|��rj1*m2�8\r#�7�������P��8�����p��;���2��A�0[^۷�;�뻎������v������#<(D��Ƞ��L��?�\\4\r�:��9��]��%-B�A>��؄�?*tT �dp�#�?'Xj��°�� 演�\":�Z����0�gVA��#eA��;\0�`h1����fݪZII���t��zQ/�̘C��� ���)�\n@P ���9�HQ�((* ��,���A�0���l�Y�5�\"���)�+A�]��\n�Z�!�\$������7[\0(*A�(q�)4n�1��Ln��n�պ�`���ph�vޙ\r�3a�����ɣ�PD����-�Р'��H�*�FfQ�B�LBI&�\"�2����7`��>�J�̜k��\r�@ơH<�N�عdN\"\0 \n<)�B��>#�3����*/I�W̣K�i%�W2��`v(�u��攣����VS�mT)#ɐ��\0�BaH#��Z\0�!�XLd���(��MF��H�4��b�c`�/=V\$��Oǹ\rѺ:�(��2D��+��I��Y\$�VaVs�z��dI	�Mi�%M4�,�l�5E����>�L�P����ڀ�	(-P�)�Tr��3'T*`Z�1�:����c3Ȍ��Քq��p�2ЄWB�*+˓?�K�&��I�A6���ӎҋKsdů\$3�y�=��:�L� ab�Q�<R�&��:��`�-��R?D�7Ϫ�ͺ �����	sQ�.C4�_��Che4�3@SEr��=�E?��Q�<Pԋ^C�\$O����d�&�B�RFX��Չ� ��0�";
            break;
        case"cs":
            $g = "O8�'c!�~\n��fa�N2�\r�C2i6�Q��h90�'Hi��b7����i��i6ȍ���A;͆Y��@v2�\r&�y�Hs�JGQ�8%9��e:L�:e2���Zt�@\nFC1��l7AP��4T�ت�;j\nb�dWeH��a1M��̬���N���e���^/J��-{�J�p�lP���D��le2b��c��u:F���\r��bʻ�P��77��LDn�[?j1F��7�����I61T7r���{�F�E3i����Ǔ^0�b�b���p@c4{�2�ф֊�â�9��C�����<@Cp���Ҡ�����:4���2�F!��c`��h�6���0���#h�CJz94�P�2��l.9\r0��Զ#���5��	,B7�B�,4��B9���8*Mc������;I��'5o\n\$�?�@�C�:!,�8�c��;�C��#t�7C� l���ҫP�\rc ʢ(C��2���	��\" �p��8o@����'�C�kIR�,�\r�#)5x���uma#`@��Ұ�N�MP0�p!X#͇_\$Cu�d��Z0���\n5bD6�%7�5K�W�p�Gɂ@t&��Ц)�C \\6����}�B�GR��lG��R���2�B*c,��W����x��m4#H��:�k����R����\0�����4�5jc�dM�ll�6�N*V�X�5]�A�c�,�P��nS��Sc�PC�d��9���[��z�g�ざh�\"/�d鮗�i�~����n:3H�`��p֞�)�pAVS\nw�H��L�Ρ��ufɤ4ɸ�7�M\$���.�c�X����S~���蚄ɫaîR7�\0�3��:� t��|S]bT���x�9�� ޏ�O��A��c�I9���^0���a���Ն�rǖ��(�e>��;PT��(��Q�jIX����\$�@�3^\r�>����� v\0��;Gl�Ӽw���:�lÁs�x� ������P�\$6�v��q�{i�1�.D�aPe&iBcZF�F&A��A��M)pc,��'�I	�:L¤��6���~�I��z���P��{I#d5��͛�\"���7�b��\"��4�C&e\\�z;D�Y�� �^Q[Ǘ���\0d\"NL�7C��H\n\0�<Ǳ[]@(*\0��%2\$�H�r!����F(g8ќ�\$�+�B�r1\$��&�\r��B��6��M��s��EɆ\$��is1�r#���fYM#�d�H�)G�<�������rg�R^g	�������)�	�5o�h;��G���	����S-A�<��4@ԙW\"H�0�&T�`�� L���C^��1!�L}�ef���g�\\�xB�O\naPB�<�BeAT�ߨD�����MA�@Qpf\r!�:�1 HrRo6z���J±A\ro�0�	)'*�\$W̴G�\"��7��@���7��E��N�QKL<���ttE��N߇3�����ɰ߆*�o�Y����=J=]�!P�h����y`���:��њV�`\n0_t6-#V�l�ֳ崏#%�7���4F�AZ�CkK�+a�9�Vw����x�ӈQM�a����6���@\r�(��P��q6�����1f��uT*`Z&������m��Z7�����}��Kr�_J�c�*���ܐ�\"Dȩ#1�z�C�l�Aj�� ��E�^S)�XK#�F�B�s{-�:CRLt���?�#,@f��`'d�jhC��\"�\$�-;x�Sm'e�V���Pj�����)4�e�ɔRi�,���\\�d\ri�'�	�\\\0PK#-ES���&o\n��GR�Z��F���\0��`0�#B�a?�\0߉\r)�š�";
            break;
        case"da":
            $g = "E9�Q��k5�NC�P�\\33AAD����eA�\"���o0�#cI�\\\n&�Mpci�� :IM���Js:0�#���s�B�S�\nNF��M�,��8�P�FY8�0��cA��n8����h(�r4��&�	�I7�S	�|l�I�FS%�o7l51�r������(�6�n7���13�/�)��@a:0��\n��]���t��e�����8��g:`�	���h���B\r�g�Л����)�0�3��h\n!��pQT�k7���WX�'\"Sω�z�O��x�����Ԝ�:'���	�s�91�\0��6���	�zkK[	5� �\0\r R��!K[��hR�;\rȘޑ,�x��px��2(��У�TR'-`��� @1G�(�R\"j9�CP�\"�P�xH b\niӸ4�8�3I���/���4��C\$2\r�+0�c�\"���JÔ�*M���\r ��P|��OL����t�!6\nn��4��:�B@�	�ht)�`P���نR�uiJ.�s�j24x�\0B�ނ-(�3ӊ.�!C��⎰x�7�q��?C��1����3��r��ab`9Y��K)kZ�!Mcpꚅ�R���8�67��)�B0Z��*XZ5�tcG�M��絰��0�63V<��Ш42I[l���2�#%҅[���\$Hx0�Bz3��ˎ�t��l\$8�γ��z����@4��xDh+bb���x�X���)�\r�6'K�C��7N#:p�HK����Z5�c,[\r����apA��9^[����g����ּ��ݟ?\nS�ÄJ |\$���`�Bzn��)nzƑb��3�Ν4�B8F��)��h*:87(ֶ��.�z�K�3�>&�#b��e!�@�9�	�֝�k�!���àИ3H(��{�\r+h擮F�;\r)�+��Z*p�2��@(	�Z�_c�(@R�L��	��@��xH�� ��_ax.I	�#rFOq�4%���r����/�Y�G��s`H�~iJy� ���������n�CŬ�k�\r�1���fM	v{�`1��P	9))Ĵ�� ��1>�������k|ml���R�c(�����v@�h �Jb=�rOC�uZ��3b^�Y�S)a����a�r�\$��\0�¡V��3��۲ZE6�0�H�[�V�|�����)9'd���S����\$��?<4lz#�)dt���R��\naD&�Hg�c(�P( �2�SC�.r�@8�R�8E\r�]r�ɪ��S�N	VTgT��С3@�	:�G�%U���BT��Q�\\��	�g�u��\0006�֜C\\EUnaڡr��]	��a�m0��k��v\0�08_a�3��V���B1B��7�6 ��RJ.����@i�Bt(%�\"3Miv#|��0�1�@a��ʂD���C?��ޗ�(v��]7�aQA=�#���F���0-`S�Zթ�nu��>��`H'�`��5��JA7�,��*zBP@V-����>�B)+�E��!4�,%[(\r&����]TR��\"�U\"`]@";
            break;
        case"de":
            $g = "S4����@s4��S��%��pQ �\n6L�Sp��o��'C)�@f2�\r�s)�0a����i��i6�M�dd�b�\$RCI���[0��cI�� ��S:�y7�a��t\$�t��C��f4����(�e���*,t\n%�M�b���e6[�@���r��d��Qfa�&7���n9�ԇCіg/���* )aRA`��m+G;�=DY��:�֎Q���K\n�c\n|j�']�C�������\\�<,�:�\r٨U;Iz�d���g#��7%�_,�a�a#�\\��\n�p�7\r�:�Cx�)��ިa�\r�r��N�02�Z�i��0��C\nT��m{���lP&)�Є��C�#��x�2����ƶC��\r��;\n�9��P���:I�|�9)���1�p�:��F�i�b�!,�7��P�0�Kܮ�pHO���:�b�6+C��C\"��0�28܍���ލ)\0˄��#�`���H�\n�� ��0�#p��R��1%�B�1��AQԩ���W5��8�v\0�SB6Z�Xɘ� R��\$Bh�\nb��\r�p�5\\�P�M����:��V�\r��� �\n7��B�ϡ���[��b6�M��A�`�7�c`��d�����9ЈX\\F�:8A4R�4	h@������4�'�\nr6�N\n�a6��v!�J�v+��,�8�(9\0ߑ8h�K��W\$�a^4f#vf��b��#��^9�;#x���:��H0�\r��3F�)���7uŠ1׉�\0���텥n�����n�؀��\0�2\r�\n֌q\0ҍ����иc0z+��9�Ax^;��r5ʯp\\3���^2\$	27�}�B�� �|ϱT��9��\\�g'�@���X�����8�D\"��Ð[,��N�o)g���AV�}/O��}o_�vC�h��������Q�\$6�ޏω�#��E��P� 	�\0004�6kQs&8�Ȝ��nA9P��\0�B�d^Q'2'T(��B�-C�b�Ś�9[ ����v� :*����A�j? a�3B�2��0�ãX�\$4��@�xD��G,�Ñ�1D0�BS�҈+q����xa0t2&q���^cIӍ�Ԏ���\n_9O#���06�H�@r\0�#Dr���y, a�)5\"�\n|q@��2BE*��,rOm�PZCtIwD�F����ض��ppo�- ���0r����b\r/��6�0��n�۱>(X��TN�� �p�P@dK�rW%я&���܌),��r8Ӡy�����ʢ�j��Brn�2�B8F�y�/�L����R�\$�%�ƲfxS\n��N��\n0o)LlԸ����������\n�T���J�\$�K�E�N�H1E�� �3@�@nQ�d�R A�L����A����\"䨍C�@�mJ�&��*d��*R�Qt��8tj��+����j�\n6��Uh�+�����z�Μ��2!������I������la-D7�:��)ؐDt��tI#(D^�T�7��T��X,p��<M�����\r_+D��m���f�����֫��`w�������A*X��Ɍ1@�H\n/ǙO� jH�E=g\\�Z4����8#��Y�aholk�����ZL��h:�p��4gWN܂-�P�#�ZCi�%����;w`�Rȷ���۠�`w]��!��h����xL��@LUJȘ\r�� u�o�p���|�\0";
            break;
        case"el":
            $g = "�J����=�Z� �&r͜�g�Y�{=;	E�30��\ng%!��F��3�,�̙i��`��d�L��I�s��9e'�A��='���\nH|�x�V�e�H56�@TБ:�hΧ�g;B�=\\EPTD\r�d�.g2�MF2A�V2i�q+��Nd*S:�d�[h�ڲ�G%����..YJ�#!��j6�2�>h\n�QQ34d�%Y_���\\Rk�_��U�[\n��OW�x�:�X� +�\\�g��+�[J��y��\"���Eb�w1uXK;r���h���s3�D6%������`�Y�J�F((zlܦ&s�/�����2��/%�A�[�7���[��JX�	�đ�Kں��m늕!iBdABpT20�:�%�#���q\\�5)��*@I����\$Ф���6�>�r��ϼ�gfy�/.J��?�*��X�7��p@2�C��9)B �9�#�2�A9��t�=ϣ��9P�x�:�p�4��s\nM)����ҧ��z@K��T���L]ɒ���h�����`���3NgI\r�ذ�C����J��U�bg&��g6h�ʪ�Fq4�V��ic�fy�����g��p�T�5�m��h��4L���z),KA(�C�����2��)r�5�>�xH�A�'��2[�mB���������^��&+d+��b�.�H�W���]�Q�\"��h�4����F\$�̧�&u�B�5*���+�t����z��.k���\"�o*�f��;!u���yƬ�鬞�\r�eꔙ���@T��HtgU����J[��)x�i{���k�*%�ȗ\$ls�& P�:I\$�r��򧶳��DCͲm\n�D�w���`gIȂ�]V����~���*�ֺIYs\\�/�R���δ��=�Cnt��q��Kr2v+��l���Q:{z�?��\0�{�.a��W��j�\"�:�>��yy[z�v~���^��z�ا�G6I��)�|����jH8�0�ek#��*A%\$�!�0��r�<�1.���x�Z�Q�@��d�A�*�t�4��!2�H��\"���PT\r�4�`̠��\r���CHnNP1�� ����C0=A�:@���/��6���p��3���\"�!�H�^��yPQ�%��^A��8Ӫ\\ʋ�X\$!�>����Z]�1�!g�`I8�D�D>#�I1dZb5���L��b�Z�-EȽ#d�Ѣ5F����RN��;G�ʢ�j�R1���P��Y�@E�g��\r\"!9N,Ť����\\K�@'Ԓ�洒�ȼ\\P��@W�WC�ľ\$�q=f�R�GԹ;�z��\n5�܃��3\$�A�������I\"hO��1��\"�8j��>�Ðm��0�e��ua��0�Z�l\r�(р�@ �	�<R @��X\r��0���aM��U��ے7<�N�Su�P���N��9�⁻%�+E�!1�9�ֲ~j� \n (\0P`�K�< ��5jJ�I�//`[����b��10:�@�i��2�zGaӘtP��&��*-2�ߕD�&]��\$)T��6dh,�4E8'�)�p���7S�AC�u���9�0�׸w\r�1Ә��\"�O��1��L(�2Gp�u�6��qX��\"(��b\"��e6EDi\n�F8��L(b�	q/F�p��0H �:2��\$8|��I�N�sYdʬ���0b�AZ��ҵ�]�!UG�B4�Pc�\\�@L��@��\0��\n<)�HB�	9Ԁ�.�C�oD=�H�I;��Q� ������B�jۼ���߲@�O���8qB�zO�1W�.�\$2֙��2��0�.�T �#J�|�����輵�~���λ���i�Ԋ���+���J�{)eR��H�\"�����;�UC�N�!=x#�\$�Et;\$,�}3g^m�Ph!����E���TӴW	��Hx���c����t؈�W�ܠla�6\\@�&�%�E�NM��y�\n�C�y)�-��7�<Q!�DȌ�ը}�,�!�QP��h8)@�{փ�������m�/��<Ԩ[z<Nc空I���,y@�/f9WS�R���AD���L���L\$���L����[\$��ce�^Qq�\"�5�o-���φ��N]�j����\$�[um�+�&�0�O�V���(��d�գd�s�=��n��t� ��@���JN�,\$l���F�-At�+!��n�V��.�����J�k�w�'\rƴ��e�K��NF���JǱ�2���΋��D�1;���v)���pVx�4u��؞��������!^Iuɜ�>b";
            break;
        case"es":
            $g = "�_�NgF�@s2�Χ#x�%��pQ8� 2��y��b6D�lp�t0�����h4����QY(6�Xk��\nx�E̒)t�e�	Nd)�\n�r��b�蹖�2�\0���d3\rF�q��n4��U@Q��i3�L&ȭV�t2�����4&�̆�1��)L�(N\"-��DˌM�Q��v�U#v�Bg����S���x��#W�Ўu��@���R <�f�q�Ӹ�pr�q�߼�n�3t\"O��B�7��(������%�vI��� ���U7�{є�9M��t�D�r07/�A\0@P��:�K��c\n�\"�t6���#�x��3�p�	��P9�B�7�+�2����V�b+��=���n\$b���F&\r���7�S��R����*�)!12���\0�<�\0HK,�k�P<�+;��xH�A���0�a�r;��HDF'�P���K� �c�:�L,���L�+8�x�2\rC�+�sJ�K���/4��K���Q�U(�	#���4D@P�\$Bh�\nb�2�x�6����c�\"�+?���=7�\\4��P��,�Z�@#0��\r�˼�4�sv!��jT�#Ӥ�*\r���784�uB�#��:��d���ab�98#�0�.�,�#p��R�^[\$!�b����+�S���6��?W7��4���@���2�6߉L�\nh��0�%�	C�X@a�*[�3ϊ5�%C�<���`RZ<��A�>41�0z\r��8a�^��H]	jo��3���_;��p��A���-A�^0���uw8P��õ�L����kx��N�ϤJA�JI��/	P�c��U����pA�3��{.ϴ��Xɶ��~��k�<�o\nP|\$��0����C�i,�s�\$c�6�'7���\$��	S<14���r��ٻ#:B�1�� @;��g��Zd0�Cft\$Æ5����/O���P��u�qW��0c���x(5wS¦���}�A<5�F��H\n7�bPk��()@��B`Ù-��'��	�4d����F�pt#G�͆��\\��w9D����.Ayn\\�2����-'���P���Lr��0��H�Hpa�m�:d��Ɂ/z�����E�+N\\A<@ck��p�j!'�O�\$!\$F������V �( 'L�Pa�,��hH�y[R&��sM�L1��(�7CkQwe��@����6Q��@�Te�I�<��^e\r�%@�Cч%e��x�Il�;��E3,^8G����\$�[&p×�X��r}�0�dE\n|`�\n�#�����s�A�!�&�Pʣ�yj��iT��a5TQ+�\0��/sʄ2���E�f�J����^F���VA��W�4,Kr��2思M#,���h�4��턅P��h8@g���h�L�%�P���\n9E�]�P\\���8G�1\$*�2�>m�0a�<�� ^L�t�0�c��Cm0�݅S�y#mE/.^6�����%IC�0��������V(�7���bC��t�\n��Z�����4�F>�QRM+\rE湗�ț��7r�z�bN��-����^@T@�^���4��Q*e�89�";
            break;
        case"et":
            $g = "K0���a�� 5�M�C)�~\n��fa�F0�M��\ry9�&!��\n2�IIن��cf�p(�a5��3#t����ΧS��%9�����p���N�S\$�X\nFC1��l7AGH��\n7��&xT��\n*LP�|� ���j��\n)�NfS����9��f\\U}:���Rɼ� 4Nғq�Uj;F��| ��:�/�II�����R��7���a�ýa�����t��p���Aߚ�'#<�{�Л��]���a��	��U7�sp��r9Zf�L�\n �@�^�w�R��/�2�\r`ܝ\r�:j*���4��P�:��Ԡ���88#(��!jD0�`P��A�����#�#��x���R�) ��O \n�\r�2�(E�z	\r�b*�0`P�෎���dL��H�5��1##���\n�<��S:��\\�xb	�t2C@�:%Ic\0���|�4�K���44�B(Z��B\\D���P�2�HJԛ1�42ڤ��I=��̶:�O��7#��\"\$	К&�B��*�h\\-�5��.�B�F�1�\$gCdj2��Z���0̍�������d��%� ��.3��!\0�����c0�6/�4Õ�0���څUN*��@���xĘ�a\0�)�B5�8&W<�ªW�Z���0�ݍ)����镶�%)xܞ��4̽(�\0��P�62P9^��!��xߍ��3��:����x暈�&H9�H���p^2A#��}�?�{��}k1#L���!H3�����e��cX�Č��n½�R9��J�<��1�h�6��i�v��f����kP\$\rkA�	#h���cp�mP�=�z��cZR�%Ox��k#��A0�z�\$�X玳���#ǯ���5x.}�嗎Q�0��c��]We�xoKg��\r\r4�1�@1�Hg\\4�C�j\"�\nz�^�Y�x�-u@�Y�,��%t�ו(P	B\0�w�� !�\0���I��fF��@h�!%a�;�|&M�;���YihA�;����B��߇6 ��q�5��7��K�D;�`��I8gh���ķ�T�'�ߓ�Z�\r�nA���\na�x H���\"�\0��&�\$��,	)�\$V>�^Ѓ�0��32�Z��k/ͽ9\r�5\n<)�@[��)w�m���𲈩Cj�ɼ���\\y��	S�|?!�4\0Z`��Y��1�����{�7���0�\$a����`�,.uJ'���\$l=����d��\0�����d̠�������\0=�:��Pty6%��A���U)���=e�9(4�4jXk&dp���\n\n\\�8�-���0-�S���S*Dq2�_�Yr!�p�\$\"z{��X&�`���\n1l�%*щ�B'��>)(z�8�H�QByR�\\\$\$(��U��Cii%&���z\\v�`eOA�7�BLN�T80X��R������×G��B[zA*4�²J�M�,�ԝ����Z3L\nt[�򪐂^HH";
            break;
        case"fa":
            $g = "�B����6P텛aT�F6��(J.��0Se�SěaQ\n��\$6�Ma+X�!(A������t�^.�2�[\"S��-�\\�J���)Cfh��!(i�2o	D6��\n�sRXĨ\0Sm`ۘ��k6�Ѷ�m��kv�ᶹ6�	�C!Z�Q�dJɊ�X��+<NCiW�Q�Mb\"����*�5o#�d�v\\��%�ZA���#��g+���>m�c���[��P�vr��s��\r�ZU��s��/��H�r���%�)�NƓq�GXU�+)6\r��*��<�7\rcp�;��\0�9Cx��H�0�C`ʡa\rЄ%\nBÔ82���7cH�9KIh�*�YN�<̳^�&	�\\�\n���O��4,����R���nz��3��Z���3B�\nS\\�&,Z����ʓ2e�4��Sc!\$��B�%v�J�	^�\"�#�&�@HK;>�����{��A b������\$D#�Yc+1�z��I4���::���Έ�L	r됉�CR�ѣ���|��鼭L��tF)H�h���Ԥ����&[2l�_&�\r����ŀ���|���ii�	�x�OS�<�[Mrn��Z~��d3��@t&��Ц)�B��}�\"�Z6��h�20�3W�J��C���6I)D�&����\$d��9-,Ȱ�M�r�L�~�,�\nǐ(�R�6����cS�ҏ&�QQ��\$XB%m��\"H0��sS)eYf\\�f	^dlT&�k>?�s��u�D��ZC�]�֊��b�)�\0�7�qR�<�̰�X!vn��L�v��)�ێϸƝ�T�.�����\n�@�\0B�4.:įh@ ��k���\0�ģ\$�@4C(��C@�:�t��t<�?�C8_��\$N0��0��A���/hx�!�)Ev}���aT�?H^5��j��>̎�&˲�䗴E(&��2Bo]Y�C���zP���u.�ֺ�b�ݫ�w.�޹�܁�s�xo-\"\$H�aC�-U伹ʙzoUM�U��0�bg\0Φ�V�ɑ<\$%��+%�Cȋ} ���w�C��;X&��e��I�r(L0�7���\0w\r!�6\0ĄÂr��6�T�C2\"C��:�0�C�s��*����dQ\r!�46�Є�|]tN���C`s+j�\$��(TYR_n�@��B��N0��B���i]@\$��\\8O��8�P\n\n)pń��v�[��Xe\0!�x�`gm��\0�OZ�z^���Pp @A�H����\$-��3䒔�cKJr(����h �.�9����t��8Y�9�HwAI�;���㫞��+!9����)����SY�F\$��b���R�L�\"�b.WIj!-�h\0qM��*f����:H�y\r��@ҝ�YDi�:L�ZC�h�����6�z�H1���?�����\$⌡:�Z���\"Z�szj�:�P������ET��2\$�~�)?#��`Xp�D�X�l5}��C�XQ�e?kh)�����؀4�Jt�˂0T��U'�cP��C1�����FI\\&'-F8Dܩ3>\"���T��L�2mMnJKZP(��E�<��n��}�J�L�m����R�S�i�KD�������eu��: ��`+���5��H���g��͋-��YB�T��1��\rY�<��E�k�ro�N�&bߑ�t	:^Gj����JcR_��\r���w�S1����@�R�}�Xϟ�db�9J7'j�C�f0��Z�\\���pJ�	��י]��(D�Y6�ܕ�h���4d-~���H�F1\$�V�!DȒ(�K��⓳I~M1#�����mj�IXU���Y+4��%e:}�p5pƨ5ˡ�0ڍ�+W\0�|Euqy��e�\\�";
            break;
        case"fi":
            $g = "O6N��x��a9L#�P�\\33`����d7�Ά���i��&H��\$:GNa��l4�e�p(�u:��&蔲`t:DH�b4o�A����B��b��v?K������d3\rF�q��t<�\rL5 *Xk:��+d��nd����j0�I�ZA��a\r';e�� �K�jI�Nw}�G��\r,�k2�h����@Ʃ(vå��a��p1I��݈*mM�qza��M�C^�m��v���;��c�㞄凃�����P�F����K�u�ҩ��n7��3���5\"b�&,�:�9#ͻ�2����h��:.�Ҧl��#R�7��P�:�O�2(4�L�,�&�6C\0P���)Ӹ��(ޙ��\"��;�4��KPR2crc \ni`�9�-��4�L\0�2�P��6I��<�c�\\5����.�@�:��,���h�׎è��L��\rc˘�#�PH�� g@�2��6�����9B`�54�\\�)Q��D�\rÂG6��cN��h�Hb�4EKc&#MPč4�ʁ15:���N5�e�F�\r-0�`5�em(�]9�E �^W�%�b5V5��EVP7=R��	�ht)�`P�8�(\\-��h�.�T�~�	C6G R\0�)c0̘;�j��rbj(%�v'�-��/��`4ɡ\0ڦ%(��)�24:��3:Kc�0�\n�.�KB4��������a�8��2�w�6*ee�X�y����ˍ��듐dH�H���kE1c�[.=y�f4沞p�@�{������hM��(U	��b��#�;�pASZ�XA!M!�9��ܚ��`�0j�V楷zxҨ�h���<Н��\0�2l�b1��\0#�@�2���D4(���x�݅�?J���8^����n�)�xDx�@�|��8�����uQ�����Jjl��L�Al��I��6ή�JB��x0A�wa�v��l�Ӽw���'��*A�<7<����4\$��=\$Q�oG�H��0�h\\M)m.�b��ܸ\nz������\n�v4�LR'�(E@ !�����` H�':BH�:Ϡ�P��s���������t\r��d�f�%��\"c��\rF�4��iڡCE%�Р�-\$�>6B��AN&h� Ex)R������j��e�����P�d[\0e�%Q� �LX >���EɫoM�����XXL:9��%R%q@3��.ɢ���s�øh\r!�-����\"���Rj˹@\"�����I�m.��qCB�j�ѧ[-�%���H@v#� ���8@e\"�U	\rnJC�9fy-%^�'I#�1e�5��I@rq&��вrH�O\naP�i�[';~\nl���GII 0��w���<��\r��4�rrH�!D*e���E>I9�jD�ד��Bc(�P�\0��:mL������A���ZKɉ/%%E5���xVAD'u��Vf��gTڭdR��S�tMejqg�7��z��;�I�a�P�����5V�fuK��G!��wl�ipr�G�0���)*E����z�X3!T*7�q!F`ɸI����Ni�L�^���/Ϲ���O�A�4F �p�ފ!6��Y���aL:A�\n�S��5�\r���O[����G3�bߕ'15���,�@Q��-ξ��㭤��vָ��i��E�2��������Rs^lc��6 ()`R�r��h+�4��";
            break;
        case"fr":
            $g = "�E�1i��u9�fS���i7\n��\0�%���(�m8�g3I��e��I�cI��i��D��i6L��İ�22@�sY�2:JeS�\ntL�M&Ӄ��� �Ps��Le�C��f4����(�i���Ɠ<B�\n �LgSt�g�M�CL�7�j��?�7Y3���:N��xI�Na;OB��'��,f��&Bu��L�K������^�\rf�Έ����9�g!uz�c7�����'���z\\ή�����k��n��M<����3�0����3��P�퍏�*��X�7������P���\n��+�t**�1���ȍ.��c@�a��*:'\r�h�ʣ� :�\0�2�*v��H脿\r1�#�q�&�'\0Q�D�����LR����p�0#�v�1��o���S;��!�\n�Gр�ԍ�&62o�苌��Ɓ�HK@��v���H� j���(�B�ʛ!���%�\n_e�*J�~6��4B��M�#s\n�nR2���|)��Sv\nI�T!hK���o<��8@�\$cΔ'�['��]CP6��k)Nʣm6��<��҇fCO��\$Bh�\nb�5\rAx�6���Á�\"�\0����`��#s'f��F�OET�%�z�§B���#&�V�\raT\rイ�a�4M=)���ab�j�\r[~As��0��H��×��[�FU.d�*���cFfT�y�q�3Ӂ��:��ZU`�:�)Ш7�c+2!�b���*���–�l��g�J�\\6��{*�0,�ʃH�\0CS�PJ3CB 3�ɱ!��H�)*�x�����CCx8a�^��h\\0��r��~�����7�}��N���}���B�<.�d�T ئ�1mSb��g�&~:��@�7�iCZ��_�͕.�?t]'L:uWY�vé�v��B��!�w�P���J~5O�zR[RK�t0�C2�	�z6O�8�7�h��Azg�횒����#M��-�^�ûw�' �ҁ�����ƲC�f3��7��3S>Gdp0��eJJd(�\"�&�\0L�a,i�\n�a	AI)�Y2����QFhAT\"������HCq%9 )\\�U^��o5����u��ci	>ot��p؃(dp��5�P��ك2�=�#�*XI=����)Cppl�t��r\\�C�7&�L�:hfa�\\�!�������C(�\0006���H\ny�%&M�'��uzF��xWJ�\r/P�3�NjM[�]K�t�TpeC��bф2ʩ��6(�d���9�2�'A���T'ō�p����\nG~i%�V	�?�EH��֨��ՁT<������dhf���Bh�(:�eq�()�m�\0 �r=�(1\")el�0��]�R4�h�4��l%d���ғ;�y(K�ɐ!�	��}{ �l��ܺL�lU0A����*`B~��¯�3�V�f�0%��JضȄ�}��iW:�Wkk�1��o.aZ^�;U�t�*�*a`C,A��4:^��+���z>m�<��:���SC�\r&�Ō6-'�Q��q�\0�0-�@�P�akZ�,2���\ro�r��z�\\FhN�1\"\$�����O�-�'�t�X4̭@U�f&�j�u5D��֑ D\rC�Bm@�^���aí�x�O�:I��(EA�k������a�^>`5���\"�\$2<�s*�L�4d�z��-��uYV�h�0Xe����Γ�%���\\C���k�D��s`���L�`(+Y�qPfX�?M�";
            break;
        case"gl":
            $g = "E9�j��g:����P�\\33AAD�y�@�T���l2�\r&����a9\r�1��h2�aB�Q<A'6�XkY�x��̒l�c\n�NF�I��d��1\0��B�M��	���h,�@\nFC1��l7AF#��\n7��4u�&e7B\rƃ�b7�f�S%6P\n\$��ף���]E�FS���'�M\"�c�r5z;d�jQ�0�·[���(��p�% �\n#���	ˇ)�A`�Y��'7T8N6�Bi�R��hGcK��z&�Q\n�rǓ;��T�*��u�Z�\n9M��|~B�%IK\0000�ʨ�\0���ҲCJ*9��¡��s06�H�\"):�\r�~�7C���%p,�|0:FZ߱�j�=ΤT!�����`\r�+dǊ\nRs\"�jP@1��3@�\"��V2���:<�(�C�J����H����PH�� g8�/(�9�lz*� ��~'��*&FJc� �c�a�sh�,H�R*ǈ��U\r��P���o �2�;�sR�̣-,6,50�	��t�/�CU�:�C�B@�	�ht)�`P�2�h��c\r�0��U�Q0r���r�Lϲ�n�J*�FQ�SR�2�J^� ���L'(�a�����7*�EѡbE-�C\n����Z���`�:ˀH�Z���_j��s�8���L��L�v!\r\n�x���)�쁍�}bT��Z���Uۭj��/#k=� U���x��ʋ�*��\n�#����A;�a?�)Xʎ�iHx���C@�:�t���B{#��{\0�꜊��}�ïXx�!�#	����i�棁\$�`�+%-���ߙ�++2|z�H�N�QC�]<����:���mۆ�n���;�&�p��Al;�J�|\$�����)P@�2�\0vOG=&��X�%<W��M@��Ѡ�X�\$�K15Ls�^k:sd��\0w5J�����JXeK�3S��Rhsa�����)����\nP�O3e\r-��دAH1y(�&z��*h��梁H\n7�SA\rAV&��3�F��\$D��`I��5����4^C��@�|:9���C�\nB0��(�l��BwGI\\�wT��b(\r��31B�U�X&l� v��k��\\7 k��w/)|;��]\n`gnI���H<�Zi����R�����'�ҧ�Hk_9K)��\0�׃3�k��:��J����t��W`�\r�I)�)t/âHI[c;	9}LWλ�!�����:kB�O\naQ~/U^��9��)@��m��3_q�ZKf������RZBD�Q����C��%*��H�JQ	��p�\"o	�<�`�μ�\$�Ճ�w�d�Z7�Շ;s��޲�&�6��I�Aa�-\\��b+Zk�R�7�bh�i�+��IX+*���ѭ�i<�4`Xcf��(�J��%/�����]I[�댋�H_��J4����T��ԾKCa�\$p�	��gAk���P�2F�� �aI-�0a��T���?�l�`�*rוd�U^~���Vj�z��R�O�-W�-���Q:8~R(���\n�:��V�񴩨o���(6p��ꞨeK����^��Rey�7ʶ�PE�ʽKȝ���h*��s����7��]�\$G@";
            break;
        case"he":
            $g = "�J5�\rt��U@ ��a��k���(�ff�P��������<=�R��\rt�]S�F�Rd�~�k�T-t�^q ��`�z�\0�2nI&�A�-yZV\r%��S��`(`1ƃQ��p9��'����K�&cu4���Q��� ��K*�u\r��u�I�Ќ4� MH㖩|���Bjs���=5��.��-���uF�}��D 3�~G=��`1:�F�9�k�)\\���N5�������%�(�n5���sp��r9�B�Q�s0���ZQ�A���>�o���2��Sq��7��#��\"\r:����������4�'�� ��Ģ�ħ�Z���iZ��K[,ס�d,��N\\���Z��n3_�(K��1p�j�Í�`S5���P��9��R��Z��l>��\0PH�� g,��ۚ�Ip�ZN&��M(�\nɯ)������� �H�c�妨� #�ht���I ���d��L��\"�Mr@KɌ� ��HB\r<�S�����{P�#�ؐ\$Bh�\nb�-�5h�.��h���\"7;5�T��8�h�:\r�\nz��Hʷ��b^�GRzV����z�W2	���Lb�P)���m+�ӨxX�0d�up�ԩ&�I���\"\\��8���s�oY��s�4z�:\n�����%,�H	z����q%�\\�!ah�2\r�H����y����\r��3��:����x��C��o���x�\0#��7�|�!,Y:�}!1cN�1\n8���#��{��1����͚�Ĩ3����VY�f�i�g�y�dN�]�h�c����^�����J�b��G�j�m�Y�8�/�E���I����4�*<��}z��Hbv��b���#�\0��6\r�\0�����\r�,�0����9���2�c��:�#`�3�]��:\r��=H@1��#��#`�.�7\"k�mr!~e@(	�@\n\nX)4�Y)�4\0���\"�7�\0��Hvw�3��x���<���@@�^�wyH	��xd�28\$�x��2 ��۶;�\r����4;��2 �`�8z���\$��Hc|,�3�7�{!�c!�9�T@I��sD����\$K��m5娆	�\\��a%c&H��U6@�K0Ȱ�9�P�W�N�N�NЂ�	�#���g^I�� 'p�j����'M+�Qh�\")=[\n�<1РT��p����t�uI,dڼ������0[�B��G��\n5�9c�*?�L@Ĵ[9��DXNѸY�����tNj�sik\"�&���H�.V�sCG�X��C�ABn�O��R�nh�Ԁ���-Gh���,Z���/�ا���J]J�a�U�0A0-\nFe�R�C���G��f#FQ��(�,ś�w-��ER�ĠģAK��cd�=��J*Fv	8��U�H	zݖU��G�B�W�A]��*q&�,Չ3��ILp��\$F^�kha�l���lk�i��J`*�C<LfJ\$�O3Ld&/F���LOi��";
            break;
        case"hu":
            $g = "B4�����e7���P�\\33\r�5	��d8NF0Q8�m�C|��e6kiL � 0��CT�\\\n Č'�LMBl4�fj�MRr2�X)\no9��D����:OF�\\�@\nFC1��l7AL5� �\n�L��Lt�n1�eJ��7)��F�)�\n!aOL5���x��L�sT��V�\r�*DAq2Q�Ǚ�d�u'c-L� 8�'cI�'���Χ!��!4Pd&�nM�J�6�A����p�<W>do6N����\n���\"a�}�c1�=]��\n*J�Un\\t�(;�1�(6B��5��x�73��7�I��������������`A\n�C(�Ø�7�,[5�{�\r�P��\$I�4���&(.������#��*��;�������5O��a�`P��0҃�*モ�k��C�@9E�Y45\$*��\0�\"��L�7����1N\0S���PH� i@� P���r��P�CC�\np`Ę�r�ž�\\�#��b�-cmO	m��� N���jIk��+>4`�<�B�����GC-�ef��c-YW\r���5�##XNSu�V��U�^XV}�����Qk�.06����(C��\r�h�<�Ⱥ\r�p��#��6\$�RR�4�E�֍�0̠!Q24�1�+�->����խ@:�#��1����:�7�λ�abB9)��WA��7\r��ꬅ�R��dH�;*�ք�)ɀ� ��TY��\0�f��(䘌3@��#��:0\n�\rm����U�P��\r�8@ �+�5�q\$D��A\0x��\n@��C@�:�t��;���8^��\$.:Dcp^ܳ|��x�8���0�HR��\rQ��2���0LH;�]\rZ���+;���c�i�Ҥ�n�����p�G;�r4r<�5DIͩ��6�\r�R:t=&�)4t܁�L @4�H�効*z%�uB�P\$\0Վ��R��9r*�d���J	\r��q6cZC�D��;�U�ퟰfA�I7��A\0scLp9��@.��h�Ӽd�\0cy\$4��ɸN.��?B4eRB[�F@ϫu�U�i�3��r2���\0P	B\"�ؐ�N\\)�9��n�!\n�'�ܛdm\r�	M�i}S��JT>_�ܹ3�t�K>2�!ƛ��WO��)̂������Ah֗p��̓�xA�7s��A\r!���kCk\\D�V��|P�Z3�TP�B��\n9Yy �'�D���0F:�&M�I&�Dhk�TeR�\0���L)J�,�7b��k�2�B\n��Ke1�\$��aBxS\n��އ@B�TH�\rf�8J��)J(� �:�@�N?Ƞ�BW�A��V3'u�\0�*A�_�6w�)F�Q	��ښ�hLB0T���i���R��2�����rp�J�(M\"�2şM�-:�eD��~��=&6�t�RO!G.�e��\n����P�e%�-��V�u\\�������C�dƄɱW\$�̥�p�I_�s)NٗP��h8B��g6ڜ���y��0��ʚ��K�|�0����dlZ�������BH�,Eg��T�';��}F�������+�d!\$�(CiJ�L9D�~�A�'�:�[��AN\r�hőYn`�DP9S���2IQKډ*8=p����s����{�Q�7�����F�����Dv��ۻ'~ˠ�!���2�d�(b�,�(zK��\0��K�yP� �R�Z�\r���Ӿ�2���3�`���:!�";
            break;
        case"id":
            $g = "A7\"Ʉ�i7�BQp�� 9�����A8N�i��g:���@��e9�'1p(�e9�NRiD��0���I�*70#d�@%9����L�@t�A�P)l�`1ƃQ��p9��3||+6bU�t0�͒Ҝ��f)�Nf������S+Դ�o:�\r��@n7�#I��l2������:c����>㘺M��p*���4Sq�����7hA�]��l�7���c'������'�D�\$��H�4�U7�z��o9KH��>:� �#��<���2�4&�ݖX���̀�R\$������:�P�0�ˀ�! #��z;\0�B(�4��@(#�K�� +P����X�q�\$�\r��<�t@�&P�J2\$�#�<�\0S ��Zrxjp�F�'(�֊��n�:�\"��.�Z(2�H�����6BPД:����&-X�9;�\\��!r\$k7AnC��q�\r�k��К&�B��c�4<��h�6�� ��)+@捐ñ)�7��2�7��P���\\�:�H����-�@�ƣƘc4�\r�x΄ab�9*F�Ć�!\r��aJZ*\r�Z<b��#)�b ���FXm���@�;OjZQC���6W�J\$ż)�򙺭�@ ��j�ZC��%\0x��p��C@�:�t��T(x�h��8^��\"ʍ\r+(^ٰݜ#��^0�ղ��.+եDL��j�(�z[4)�29�c��\"?#��2���6�c�E�d�FT;嘎'�Y�h��o�ݝ��ճ\r��h��82�c|��5����u=Q�B��i�ӤKɼ4����#�����\n�q���Ȑ����5�eAvm����\"JѱɊ:spȏ*����X���\0�G�W�\n@��'Q��'AB�ݾz�*,��E�q�*˳;\$���J�#~5�;�	h��3~r�LCC�%8Ґ0�FV:�(.�GJ��[A��1�V\$�4)�}���Sa\$�`1&�.CiE\$�x�#��j�C�^茞��r�N�|<0���P�-	\$<<��v��#��t�C�0#a���ۙ|\\�f�3EL�a3G��0�T)䠢�BhLOJ�M�!˪r�\\K�\$������Tyb\r��4����A����ؙ�P�E^�L(����� a*=rr��qk�*Ġ�	j=G���FbΣ�G�P�&\0�K�(0ix4ʙfO|�Q��KV�Ė�UƑ�\0R�\r��.��E�!�(��8���D��#I������\n�P#�p|�sDd~d\$Ivif�'���Џ�3�bE�ݗތ�\0f (ܦ�B��o��)��v��@2id��\n-3�	vF��2J��=�R���\$i�1ʞ����o��EX )��cH��KĖ[��e�A3��!�>���D��8\"d�-#�DO&�� z�u�Aߤ��5��";
            break;
        case"it":
            $g = "S4�Χ#x�%���(�a9@L&�)��o����l2�\r��p�\"u9��1qp(�a��b�㙦I!6�NsY�f7��Xj�\0��B��c���H 2�NgC,�Z0��cA��n8���S|\\o���&��N�&(܂ZM7�\r1��I�b2�M��s:�\$Ɠ9�ZY7�D�	�C#\"'j	�� ���!���4Nz��S����fʠ 1�����c0���x-T�E%�� �����\n\"�&V��3��Nw⩸�#;�pPC������h�EB�b�����)�4�M%�>W8�2��(��B#L�=����*�P��@�8�7����\"�H����h��c��2B��C��\0	�zԒ�r7\"�h����62�k0J2�1��!� P�\$�`PH�� g(�(s����8��\0�9/Kb\\���T�����1�jr����3�â� ��ݯ�s8�H�,�0���?�At� PSz9C�-2�(�v7�B@�	�ht)�`P�2�h��c�T<��P��7���=&\r,�69@S �\"	�3Δh��L�6\"��P�7�����Ìê86E�X�Vx�ƭt2K#\r��aJ[e�h�@!�b���\$���2\r�p@)��`6&��Ԫ4K��.J��2���ܤ���K�l��Ռ�jP��rƃ���&������9�0z\r��9�Ax^;�u+�0Ar�3��_|-��H�A���9��^0��\"w�����6��ƨ�䚦)q|�Bjt�d�AL\n��8\r9`�}e,�Y�f�i�g�u��y����슦�8D��H�8\$(�\\*4/-�0ݴ0���Ch�%�bB��i ҟG,��\$+�>��X�b1��(��@9c#�) #6І���k�^wc���t�B1�Z��9��C�č�ZGe�,�;Z���?=X�\$\n@�8-�N(�Jb���E��2H��4&h4���R�A�՚����j��B��܊�k�)��4��l�1�&\0000�5��pD�e��7�jX \\����B���[8k��?wV_\\xi_A@��*Z�F��ʔ�L�1H�Ͼd����,K���@��\\!z��1���j �j3�7�b2�@'�0����% p�իgVF�=��\0����U�G\$�x3�0�S�WQd��SF�� &3�\0�Ba@)��#G��2�N|��T(C+=:E����\r3d:(�^�\$�M��E�R����p�!,/�p��g�F\"8+�FL�XJQ�1\n�`��HT�:�P3z%\0���y�\r��6���<y-�A�â�^���%��âP����\n�P#�p{��a�#�a,��QTT�����TX��L��L�t���Œ�T\\�,���QR*F��\0_�5�P�L����\\��z~^��0F,����\n#S#�(:P�(i�(V�V�� ��y~��ȿ�F&��G��(�\0SGn�尛 /�	����ɂ4O0���Օai8\n�5Ԃ\$h9";
            break;
        case"ja":
            $g = "�W'�\nc���/�ɘ2-޼O���ᙘ@�S��N4UƂP�ԑ�\\}%QGq�B\r[^G0e<	�&��0S�8�r�&����#A�PKY}t ��Q�\$��I�+ܪ�Õ8��B0��<���h5\r��S�R�9P�:�aKI �T\n\n>��Ygn4\n�T:Shi�1zR��xL&���g`�ɼ� 4N�Q�� 8�'cI��g2��My��d0�5�CA�tt0����S�~���9�����s��=��O�\\�������t\\��m��t�T��BЪOsW��:QP\n�p���p@2�C��99�#��ʃu��t �*!)��Ä7cH�9�1,C�d��D��*XE)�.R����H�r�\n� ��T��E�?�i	DG)<EȋC��>_��2�A�) F���t���D��yX*�zX��M�2J�#�b��M�I@B���\\��!zN�A ��9�rZ6@̤		Iδ�\r���\\t�j�����ZNiv]��!\"�4{��=.r�d�NGI\\�S�II�����q�C�G!t�(\$�0Źvrd�8�*ԉW^��Pєt�3)D��p�n�B��ȉ�G����@��4g���u���0�c�<��p�6�� ȪJ�bAK`�94�0@0�M`�3�`�7�b>�bT|�<���I\n�{^6�#p��\0�1�m��3�`@6\r�>F9���囌#8Ñ��KF�����R�=di�V��	T!�b��Ks)Y���C�]�_�7�-\$zP ��-��yi�Ǣ�S7C4(:�#p�#&��ZH��#\$�Q����D4���9�Ax^;��p��dp@]��x�7�\$F��]�DwP�鑌��^0��1]�H�n�({e��!ʄ\nƣ�T��zD�Z]���@��K����M��9��]�N:2��<�t���:�X�s�r��9;Wn��D(��\"��Hm�6�p��Bt��o!a\rf�4�C`��\$\r���<�J��oD��y�؁\$���7��A���5��1�4F��hA��⃔Q��3?\0@��=l���6��\"��7a��0�A\0cpx4���(�#�^Q�*H�V\"ΘsY��P	ABh�#�����Cɜ�#�ؕ��[\r�dG{G^\$HsF�\$��ݚ�blͩ��48 ��n�1�\r�;4@�,��k̀�\$���@TJc�D�9��\"d,@�i����J4;�P�!i�EH�kaq�����49���<W�9*��@(Km*��d9�y&��\$��X��mC\$�r�\" ��b���#���I,h2�k�psv�⛦:C������!���@���R(�.f��9�@'�0�G����QM�	\"8ĐǸ���C)e4A�,;~|�0A��@��\0MP��Q�3�U�#>���M<�@���:�79g \naD&\0�,A�s�*6�hi�R٨Һ[�A�A��?� ���=�đ�b�B,��PP�M�DL�,��\"%E?Z+.\$�1�3�ϯ�i-0���ڈ\"ظlt�4�0ֆ�3��ڔ��G	�Hff��k\0\\d.��@*�@�A�r�u�Ʀ�&M�pN�+ij��f0%b�+倰��6�Ŝ鯖��D�qPt�aDs�p�2H�#��G�-��FDɐ�>����ܗ�~:�1��hUa�?�H0�=g��VVR�I�?����Q�Ā����z���������q,��{YJ��y=Y1\n�U*�%5'��|�����\n*�9D\0�";
            break;
        case"ka":
            $g = "�A� 	n\0��%`	�j���ᙘ@s@��1��#�		�(�0��\0���T0��V�����4��]A�����C%�P�jX�P����\n9��=A�`�h�Js!O���­A�G�	�,�I#�� 	itA�g�\0P�b2��a��s@U\\)�]�'V@�h]�'�I��.%��ڳ��:Bă�� �UM@T��z�ƕ�duS�*w����y��yO��d�(��OƐNo�<�h�t�2>\\r��֥����;�7HP<�6�%�I��m�s�wi\\�:���\r�P���3ZH>���{�A��:���P\"9 jt�>���M�s��<�.ΚJ��l��*-;�����XK�Ú��\$����,��v��Hf�1K2��\$�;Z�?��(IܘL(�vN�/�^�#�3*���J��*\$j�?��`��N:=38��⓻���\r���*T�(#�<�.�j)�jA:)΢R��4[{;���)N2����\n8�'3�\$2\$���8Ϥ31���H�� gZ�*�ݯr��J�\"��T���4JQC,��|�(ӊ���Ղ��;�L�h@V� �ď�4\$��N3�N��Mt�H\r��a�V|�\0��]ʴò�؎?��o_^�:=���k��UH�äÃQ�r^aؾ2�Y�&K��-�m�L.��5jC`�9e)k���	���GM&��	�8�Nm:Ȫ��\r�ef��wO̱���{���m��K)VvD�L�\rJ���K�T=c�5ؒdգ����t��N%������\0�)�B0[���{v�mRFНދ�K�#�r�Թ��fw��ђ9k��.=5mpvv������A4�O�<�>(�p ��h�7����0^ϫ�MwaIdI��s=;�?�\n��.Px0�@�2���D4���9�Ax^;�p���}�\\7�C8^2��x�7���4�xD�èk������<�4#��O�y)f�m��\"��Ct=��Q �)D[�(C��M��p��ʹi��MM���e��NQ� �)#�3�k\\�/]콷����|�����t���~/���P��s���\0 ��#�Mý�IP쐕�@qѢ\n:���j������u��%:��;�X��P{CxM�A��nܓ�A2@d;\$L��^�y'Ɣ�q�V@,�ࡲ���L�屝5ڜ��?(��J5�\"\$��J(Kz5�d���+18��#�zRc��uB���c{e��m	2I��<Q�La`����Nٓ��_�l�ʢ\rZ�;N%����Jn�j/^It��sR����2��1���^��|��:<8#�}D!�����-x�J��@�z,#����)�D��^q�A��^(�`/R4�-6��\nuS�nJ�J��Ӥ�������|\$����P�`��sd�H���i���e��f��1�tS���: �Y�`�%*���l�Ow�� �x��5Az4}�D ڔ���(�\$�w\\ҞY&RJ�鉷K������p�aO�Mn����;jQ��%���n,�l�R�e�B޲�8�:t��Oc�1}�j\rL+��#�� Y^�0T\n��Kn�L�y�]�V��H�Il��W�N�uBpӪ�K�`�a�h�m��,���x_y�m�7i��9^S��?�x�B���/��77���SdTsc)BM��#\$��S~e��i8��Y\$��z�ee������ዳ���!���84���o�b��ds<q��7�v}�]KG��S��4�ct%�����:8jr�i:joީze��uI�Z�8p�M#j��B<zH�,.	7mkQ< �\"�(�H���fSQ�]���oH���4�KE�R��ed+�G�}#d���?�f6*��B��8��Z�s+��bP���ʲ����j��y�&L�:��5��.��Z�2\nܡ�l�	�����Edb8���AT	�̼	m�hb �";
            break;
        case"ko":
            $g = "�E��dH�ڕL@����؊Z��h�R�?	E�30�شD���c�:��!#�t+�B�u�Ӑd��<�LJ����N\$�H��iBvr�Z��2X�\\,S�\n�%�ɖ��\n�؞VA�*zc�*��D���0��cA��n8ȡ�R`�M�i��XZ:�	J���>��]��ñN������,�	�v%�qU�Y7�D�	�� 7����i6L�S���:�����h4�N���P +�[�G�bu,�ݔ#������^�hA?�IR���(�X E=i��g̫z	��[*K��XvEH*��[b;��\0�9Cx䠈�K�ܪm�%\rл^��@2�(�9�#|N��ec*O\rvZ�H/�ZX�Q�U)q:����O��ă����d�(v���1��u����\\��[�u�DA�L�^u�;4���u�@@���x�&s��7M(9[�/9NF&%\$����9`�H�i4�-�؁A b���8�Hc�A�1�TT&%�J�eX꓋1{�H\"�Bi!�eM ^GśA�V0deaB/�P[)��`v�A�XKF׵�R���ǭl�DL;�=>�e�#��<�Ⱥ��hZ2��X+R��6��NԄ�׍�0�6>�+�B&��5ͫ3�M�`P�7�Ch�7!\0�����c0�6`�3�ØX�YH�3�/�A�[a\0���(P9�.{	�gY ��b��# �5r@�s΀�W��iA�GS��5!x�+��\"�Y��46:��@ ��8��cU�x@-^3��:����x�˅����p����p^2EN\$S�A�I�����}���*ru��YFFk�Dt��Ām�1�����M��9��N2k�G2�w!�r��1�o�x]�tIEP^*��6�\r��Ў��e��+��i�h��5���\r�d��7Gh;���,<6�B�QAnF�0�7Z��\0w7�1���۰r~�40�g��-e�͘�6j��\"8��4��_� o]�����\"T��_)�4K��\0�4K������YD ���L5\"��\\e��x���*o�y��dm\r��7A�F�\$\r��6�Dvl��N�����7��T\"��=���Ä��4�ɰ��^t4z!�F�s��CF\r!�ǂK\rxc-�*�LNb�P �̤���Ɍ�'�R��<Hȼ k����f\$�/��S 8.�^9A	\$t<���Ti������oXxq��d\"[ۛo�6N���ͧ\$<�Rdݔ�T<�\r��X�y�!k�lv�ziL�`�E*�ҞTf��u\"��b,�9D�0��'IT�K�Y���j��\r8,��0�]*�\0S\n!0h�\r���R,2u_�hs�w�k��zPi	#�(�ˍ�A(E�|�\0W\"Zf����]���c�<!j�ͬ�mњ�X��f4�\r���W=�Hc\rh�����\\vh�\0004�fS�F�ᵼ@�^Ђ�T��!�7ϽtQ�D���t(�&2�cbR�%T�\\��M��G�v�s�c�y��uA\0w	�2�a�+5�2�(&�jP��8g.�]k@~�	H�X�;�� ¥G�I��d,&J� ��)�Ss�����-����\\_�y㨱�A(�RTC�R#��Y��J�T�*e�";
            break;
        case"lt":
            $g = "T4��FH�%���(�e8NǓY�@�W�̦á�@f�\r��Q4�k9�M�a���Ō��!�^-	Nd)!Ba����S9�lt:��F �0��cA��n8��Ui0���#I��n�P!�D�@l2����Kg\$)L�=&:\nb+�u����l�F0j���o:�\r#(��8Yƛ���/:E����@t4M���HI��'S9���P춛h��b&Nq���|�J��PV�u��o���^<k4�9`��\$�g,�#H(�,1XI�3&�U7��sp��r9X�I�������5��t@P8�<.crR7�� �2���)�h\"��<� ��؂C(h��h \"�(�2��:l�(�6�\"�/+��Ь�p+#�BЩq4F8B�)|7��h��%#P��₀Ў�p@̦�L��KS�:�.�R��� @��*\06�� ΂Nst�:.�P�ρL�!hH����2����͎c�� #J��T↊�*9�hh�:<q��\"��t�0���') P��1n�.JcK��k�fἮu|�	����J6�`X�z	F��e�_���F��R���b@�	�ht)�`P�<݃Ⱥ��hZ2��H���\0Ȥ�tf�Rl{#\"��x�3\r�8ʒ\no�[*^Ҭ�3��ދ%cp�J��1���:��x޳A�cN9cnB����ڳ���P9�)\"��.��!�b��Ӎ���9�B�7&n�L��� ̱��z_}��T���̌夂Q�U���\$כֿ0ܤ��8˪�&����~�,�8@ ����9eC ����@,��3��:����x�˅���Ar�3��^��� �A�I�!�^0��c?1j�S*_8�bSUW;>���,�f5\$i,��\"#��;�st87��U�qC/�r�)�s����×A�Apl7u	�|\$����~��wa\0�Q(h��N��_>�d��Gd�K��Y�<�N���blg�&6(P�h2��1�c���%FT8v�pa��߱�@�%\$L�BPi��(�3��O!,n&�����CHi\r�\"�e<�q\"����oB�H\n	|6D��AA:g (!��[��LlΗ��Xá/5F^\0��DޱF\nx��D��%D�~��B�8ȅ���\"��8x��83UV�rM��Ԇ0��K+�M�T�P�lÛHf��*��J)-%��4�D�Xl	8l���v�6xjZ������I!a��/�je��.)����C���!���������>���J�pj���\$�A��h�O\naQ}HP�cA\0S��[��=Z��`�`�0)�UdԚ��LECpf,����7hPIr�4�3e9�4d��P��Yg�Q	�|�S6�B0T�m-7��ۛ�H90�H`SZ!U��WS��\n�\"\$h���Q��@@�D5�*���M%���T�0R�LZp�U�ҳ+|�ՐŭІ�`+���1��}\\Hv%�e��Rj���'���љG\$B�T�� 7CC9\$��x���4G\nbyMU���r:�,�\\�6X��ftH�F�%�S�\\�wĕ(�\0��-��A�z���<%q\0�~_�,e���3�q�鼹��ӂ��xw<��s6�L�I?!��\0���+U�f���y�w��.Ih���R:����%�=2J4Z�\rIvj��Ӂ+-�gp��X:^�1\"mg�\"��n��S���E�ۤ��	��.�ySy�-�V��j�G��p9`";
            break;
        case"ms":
            $g = "A7\"���t4��BQp�� 9���S	�@n0�Mb4d� 3�d&�p(�=G#�i��s4�N����n3����0r5����h	Nd))W�F��SQ��%���h5\r��Q��s7�Pca�T4� f�\$RH\n*���(1��A7[�0!��i9�`J��Xe6��鱤@k2�!�)��Bɝ/���Bk4���C%�A�4�Js.g��@��	�œ��oF�6�sB�������e9NyCJ|y�`J#h(�G�uH�>�T�k7������r��1��I9�=�	����?C�\0002�xܘ-,JL:0�P�7��z�0��Z��%�\nL��H˼�p�2�s���		��8'�8��BZ*���b(���zr��T{���0���P�禌0ꅌ�(��!,�1Jc*\"�Lh���Zsjq��(�Z��	3�ɁBB�)z�(\r+k�\"��H�5\nn�2��cz8\r0�;\rä)(?�@�и�4&���tD(���	�ht)�`P�<�Ȼ7��h�2S���F�P�O\nP�I��3�h�2���ʣ&��|���䷺��¦�7C�Ϸce� #v�r��ab!>�w�(�;,�������c`:\$����7b�)ԸҨ��@\\6j0ANR0�\n�Ԏl��^���i��,��K�m��	���\nC1G l�q�`�2\r�K�w\\���9�F c@�2���D4���9�Ax^;�r���o��3���^2-(�Ҵ��}���Z�|�KL�0�ރ�\$:]Ɇ%sH�T��/KjKRW�Ñ7c�\$���~�n�~����N���������ִ9k��	Avʥ�j��p@1�p���C=D60�e��)wP�%�m�ir30���#��������3=��0��|�c�9�ê?�5>��:)c�}��~���+��.�x�8	�LoM�8(A@\$j�AAJ\$��;�paS*�]\\�x\0�M٘ ���.�^Aɉ� iz�~�S�/KP@�/�[�[G���W�k���\r܂`��zQ�4�2��C;L0��;���F�F��&��xeJl�)ģ��&B�%�/���)D�%�M�c1�Պ)���B6\n�Ân���bF��&��q�6��\0�Tq��mD��|\0K��>���Q��!�:Þ����1K	��h�E�#D�>�\0� <'�\\ǭ�,��C�K�L�0Zܒ�� �T� �6�M\"�3\$����\nT�n��tB����|�{�� ���`+e�1���j�1�vf=�\"�J�� W��#JY��U\n���J�L1��Jjb&Y�~(F��BFHɎ�|X@)�S���K��:�^\\Q�8`�}���@���y�E��ڼRL|��J��#�%�kɦ�t��T(��E)DH�T:\n1?#U�`B)/q%Țc� k��Q��Qu��|Ñ��9�`";
            break;
        case"nl":
            $g = "W2�N�������)�~\n��fa�O7M�s)��j5�FS���n2�X!��o0���p(�a<M�Sl��e�2�t�I&���#y��+Nb)̅5!Q��q�;�9��`1ƃQ��p9 &pQ��i3�M�`(��ɤf˔�Y;�M`����@�߰���\n,�ঃ	�Xn7�s�����4'S���,:*R�	��5'�t)<_u�������FĜ������'5����>2��v�t+CN��6D�Ͼ��G#��U7�~	ʘr��*[[�R��	���*���9�+暊�ZJ�\$�#\"\"(i����P�������#H�#�f�/�xځ.�(\"��KT92O[چC��0��P�0�c@�;��(\$��x����Ԋ9�r9�� '+èrJ��C�V�i̒C���A j�����B�~宮 ¾�k�W�����B�:+Ȱ�F�ah����z�8�H�ã����HR��M#-%J8hh��&I�Д�ԛL���]F��è\$	К&�B���%\$6����e�B�%\rʘ掌�Zȍ��p̠��X7��2<�����B�m'JkCI���	h��ƒc0�6r�9�6��0��*��*�Hڽ�XP9�-Ĭ�ƣ8@!�b���9apAP\$�����̻'h�\n��/&�P�v8MCx3���8��y;�:���@ ��Z�9:#4��\0x�8��R0��Ax^;�rc�!�r�3��^2,J7�}�:�d��}�����%������@��L�Y�Kʋ�f�2o��ý�,<0˜�چ��j�Ƶ�����l;˶A0^׶���6��,^7����{b7�-Wz0��D��	��r�oz���9\"Q����H�* �����x�}�#�A�����W����m�U�rX1��m��y�8N���QJ%�@\$.�!Fi�#�q�AUb (!�\"����>4F��RS6f����^bY�bid�8�6ẃ�Z,�k��uÛ�^�)����i�ra�ʒ��l�+�/	��Z\0e&�ܜ��z�P��K'��s����\r\r5�RjH�y3GI�XEI��6EM��Q�\0f)���6��(c%�M��7\$G	�P	�L*�\\I��*E0�1�@˓&D��d��\\\n�9F�6t�!SiA�3�Fڢј�a����^L^�\"/\0�)�� a)�\r'\\#HVʋ�POA\"���\$oL2�񆣍BL�J�q�Y��)��\$��Tҍ���\$�ɼ�^��?�a�r��8��`+��� �༣��ȅI��b��F�\$쒾FB�F��\r��j��q)2��� �0�|�D����eh;�f���V@N+#E��Ghr�.KYBg�C0yQ+�7����\"Č䘳�{(\$�\\d�UC�1=����IFT&��;d�&]�d�Cո��!q9�����г2��}�b�D)��|Ȯj�J��D5�y{��f��9�Λ(3\"��YEڹ4dy�\n\nV0�,T���&`";
            break;
        case"no":
            $g = "E9�Q��k5�NC�P�\\33AAD����eA�\"a��t����l��\\�u6��x��A%���k����l9�!B)̅)#I̦��Zi�¨q�,�@\nFC1��l7AGCy�o9L�q��\n\$�������?6B�%#)��\n̳h�Z�r��&K�(�6�nW��mj4`�q���e>�䶁\rKM7'�*\\^�w6^MҒa��>mv�>��t��4�	����j���	�L��w;i��y�`N-1�B9{�Sq��o;�!G+D��P�^h�-%/���4��)�@7 �|\0��c�@�Br`6� ²?M�f27*�@�Ka�S78ʲ�kH�8�R�3��\n9-���\n�:9B�c�ޭ�x��2(���\r�Z��.#���\0�<�\0HK\$�i\0�\rC�� PH� h�����@�3�k2��\n��#[�P���dN\n��P\"���ޏ�B3\n�Jl�ϋ��3�S\$)�>��c �I�H�KB��SM��4�\$Bh�\nb�2鈶�V�+L.ѣcz2A�쥣��Z���hН�-��7���3��/!U��R\0�6��x�G�**9���2�c��:���\0����+c\n�I#j�m��@��\"��<����b��#Xcz��%\$�((�5������f\n���HD�~؏(C���C\$����\r��#%�W�� �b!\0П��D4&À��x暈�^n�-8^���\$�0^��ڙ�A�^0��I�L\rnu�6'c������3��p���7I�\"V��Td�S�߸�a��h�6�:iZf��jKf�9j�����#v����H�8/0d~�l�CQp0c{��#3H���V�9Äx�)u&׶���qE��\r�c��:��N�R��@0�i�餔�w×l9A�H�3T7%�t]Weܵ����4&^��0��\0���#J��Iq.e1m�`�c\nu�E�0�cXAC�;Qn�(��`,'����\nJiX�t��6�U@PC@D]�T v�LQ�����DT�9Ź �r��Xd��\"vf�̈s\rH	�\"2h�s`�/g�Cpp[m�w�@io�}v��ߩa�:�RJ�y/&&H:C�JOâ-)��k<����1Kn�]28DC�� P��K��8�U�s�1�&,թ�#2SA(/�E2�R\r!4��:�����KciƢH�P�c���07/�P�+�'�l�=3�CZ\$��:�����>m�ŕ��̑#�ܑB�*�S\n!0�e��F\n�A��N��t�\$�)L%�R�ً.�9��@���=Dn��@Y� /��#�R��3�4�9�6�h�CztR�����`+\ri�7ӆ]�~f4�Ի��JQL\r�)�EP@B�F2�s��=I&)���o�:����9�R\r�)	sd�HtF#��6@(\"�����y�Dd��D�p�)C����M��#�Қu3K����!���U.��:n���A��H'�`�.@�g����b�`�[�:m	i�R[Q�k��\0)�YrFM|�:�P��G>��]5U`<��";
            break;
        case"pl":
            $g = "C=D�)��eb��)��e7�BQp�� 9���s�����\r&����yb������ob�\$Gs(�M0��g�i��n0�!�Sa�`�b!�29)�V%9���	�Y 4���I��0��cA��n8��X1�b2���i�<\n!Gj�C\r��6\"�'C��D7�8k��@r2юFF��6�Վ���Z�B��.�j4� �U��i�'\n���v7v;=��SF7&�A�<�؉����r���Z��p��k'��z\n*�κ\0Q+�5Ə&(y���7�����r7���J���2�\n�@���\0���#�9A.8���Ø�7�)��ȠϢ�'�h�99#�ܷ�\n���0�\"b��/J�9D`P�2����9.�S��/b����F	bR7�c`�3�Г��+���5��\n5Jbs�2�ȉ��3:!,�1L���5���/�JZ��\\��b\nc��5�`P�2Hz�6(oH����4\\���R\0�hJ��\r�\"c���6Bp����B��*�%&!#�[`+��D�W�R�)�(�P�5\\׵��\0�V%F���|AXc�g\$I����@�	�ht)�`P�\r�p�����(S�\nb�#�p���*��c0̑Di������'J3d�<e�V���Sr1�X�ʌA�;�X�3�Ì8B��Z��3P@�����c�c&����<��	g��n�?�d�w��4��`��f\nd��.m��:y'��>9�C����F�ii�����\n2Ic��\rh�@!�b�����m֘¤�3�6��`��!z*Z�W�\r��~��tK�� ��ņ���\0 ��d?�?ӻy��{���420z\r��8a�^���]S�O��3����j\0�	��xD4k�L��x�`Rڃ��U���xD�4��&�ţW�yL�\nP��(#:S9Dc:W�~�\\v/d���wN��<d��s�x�2�� ����*\0�����qR/U�%~�r�ea��GXT�} E���\0A	aA ��AS�O^�@ k��%�^�Kf�;�\0��\r\0000�7��\n�\r��\0�����L��3-�0Cc ��38V4�єQ�V5�\0�P\0c2�\r`���z1�=�>��=��S�2���=� ��p��0&A���d�ÉV*�@2t�&d:lP��I�PTIW@�'T˄�؆�@�y:H\r�A�9I8@Hq�\rMfL���*��\r�9��V�gCKl%D�zHg��R@dC �f�n5Q,���1��sa���P�Kea�3�X�8�a-��(H��~S%ed䝓��*O�ʗ�@�p�'EȨ`�BᯕE��JHA\n5da�B\\��h�6� �k\nr>A��ȶ����'��=�MVp��m+g>��2S��J���6V2�%��܈B\n\0f��Ԏɀ�U�K��4N*�SRLerH�� �G�J�Ih90W/ˈ �RGׄʊ�\$�md������.r�I�GҸy&�!1X�fJY@k0��4���d�I�@Vzˈ)])I�A!�~�2��;Y�u�6�2��'d�M��k.�Z(e��CGa����G�aݰu&�r�AN;�\$��a+)Lee�ԒwS�@�*�@�A�6��V��1` �������Oc	M'X�����z�l���Е�t��lā�\$�1T\\Hb#���R�_�G��T���e�pƜ�]\n���y5�\0�sLj&�Ϊ�@�K���C�q������r��¤k&|w%(\0*�B>z�d(G=iEl[������e�|���\"��y�C6Uq8E'X���U�P�%\0|�A����&��Xk�0\nE�(������	�\0";
            break;
        case"pt":
            $g = "T2�D��r:OF�(J.��0Q9��7�j���s9�էc)�@e7�&��2f4��SI��.&�	��6��'�I�2d��fsX�l@%9��jT�l 7E�&Z!�8���h5\r��Q��z4��F��i7M�ZԞ�	�&))��8&�̆���X\n\$��py��1~4נ\"���^��&��a�V#'��ٞ2��H���d0�vf�����β�����K\$�Sy��x��`�\\[\rOZ��x���N�-�&�����gM�[�<��7�ES�<�n5���st��I��̷�*��.�:�15�:\\����.,�p!�#\"h0���ڃ��P�ܺm2�	���K��B8����V��m��'F�4�{օ�0��4�K�91�j�\r([����x;#\"�=.A(�C����؁C���A j�����B�l1��c�8�cd���`��/bx�\r/.4R6�(H ��Ď׌p�\"���ҽ��-��r� ���B\"�)[�2�#\r7%P�o2K�m6�%��ÁC��B@�	�ht)�`P�2�h��c\r�0��\"J2Үk��W`P��MJ�@�x�3=u*q#�IT����e*\$��7�	�� 2C�ƃ\$0�PK�\$6c��_U�������2��R�^�ZPb��#��=j@\\U��ˠہ���T�C�p�u�).��W�2�o�'g)�rӿ\r�Z�����#%��)\r%��43�0z\r��8a�^��H]�p\n�3��@^�/.{��A��ܼ��^0����˫��k���Z35JP�@���,16x��Ø�V��Ό�>��k��ñ�>�;�z�����~�7n#�'�n��	#h��棦��A�����@�cY��)��-�'z���|2��b�:Nz�^\n��1����M��'�9ip��0�ܸ�`��\r�0@��9�@���W@��XlW�Xˆ����C:.A9\$Rx��42C\r� ��CqF� PTI'+�<Ň2<�I\$\r�\\�W���Q��*l�%�Fl���y��As�N|1��H�vD�I�c�βdA!pa ̄��t^�As�ͨw�o	��.ͅ0 h�ACMf�((�3�P�(%��D~c��}�0竲�A�Z�d�A�İt���@�B\$ �i�Q5O<Ɇ�o\r��O�y�b�[l?��A3voC���a@'�0��'�9Y\0Γ\$�7	h2RK��<'�fLG����5F��? f�L:y��\\��E�&q�6�	�4�]�\0S\n!1�C�@�A\0F\n������t�hGx� ����\$����i����1F0��\"q@�;�R�&Ufߢ5����A�ԊA��W+J��)�0���-����I��a����_)s\n�P#�p��	�\r���&S;@H��.��Y��m\"�!\n��ҜG�1\$�QJ)d�N� lC�\$ņ`���d�PzԤ`�\n(ն��`�����P%�5Ъ�c��, ���p|�(�T� d��N�	�!��.��E.Ii���z�]�6�9/���G-q�\"�Ml��H��=.z������O����^M�h0�R�V�T��qn5�J�-��\\v�q�I@";
            break;
        case"pt-br":
            $g = "V7��j���m̧(1��?	E�30��\n'0�f�\rR 8�g6��e6�㱤�rG%����o��i��h�Xj���2L�SI�p�6�N��Lv>%9��\$\\�n 7F��Z)�\r9���h5\r��Q��z4��F��i7M�����&)A��9\"�*R�Q\$�s��NXH��f��F[���\"��M�Q��'�S���f��s���!�\r4g฽�䧂�f���L�o7T��Y|�%�7RA\\�i�A��_f�������DIA��\$���QT�*��f�y�ܕM8䜈����+	�`����A��ȃ2��.��c�0��څ�O[|0��\0�0�Bc>�\"�\0���Ў2�or�2*����c�`��i[\\��N͉�z����z7%h207��I��(�C��R�ہC���A j�����B�N1��8�0I�\r�	�6��\n2�2�B	�S�Rj1�̠���K�Q)��B�<D2*Z�L(8�K0�4�Ib\\����SR��U�	]F���P�3��@�\$Bh�\nb�2�x�6����i�\"�2����׀P��MSX���x�3\r�\0��!ij��T�ب7�)��Sq�ƅ\$c0�ϲX� ���_���Kj����R��cZVb��#;�b�t�D�<uJ�6��z�خ���u��+{.47���7��\\�VЀ�9�!\0�2a�^1�6�� �ь��D4���9�Ax^;�t5��k���az���n�^�;|�x�]�\n��40��\n`35��:��k1�'��`&��2`81Ø�Vc��ь�pA������j�Ƶ����ul#�ǲ�i^��J�|\$���k�������Kc��;�@�'ҋ�ݯ��H�nūnCm�n���],��	���#�����R�x�o�c��\"í�ێw�%a/~�;ϼ>B\\�Q%��^��:\n�B��7��I��1�)�7�n�H\nſ�znAX\$��@�\$�n&ġ����\$�Kd�M��?��'������A�4�0¢�)��|�tB���y�@�1���C�ux�@��5��a�ޗ��\"�Fg��(�C�P۽(e���I�*%M^b�\r@ \nA�r``��B1���V�\n��x�`��h��fU&��46���cO�ߜ' ـP	�L*A#�3@CDp3�s���V�ԇ���1\\r%��Hd�S.����ӬGQ�t�����O�jc%���Q	���F0T�d�-�h:�d��\"˴����.R��#��V!�k����ϵW1���]\$9��t�A\r:	��t�J�T9�o��K5cF [&W3Q�x�(lr�4��,�����>��^�������i��\$��aaT*`ZkH2A�3���h�U�����dh��g����gL)\$��rRfz�������؊ho2A�<���hÙ\ne�)+V���U9=�ԩеʟ\0k:�N�\"w{\\�LD��,�Nc_	�I�����Cz=)ġ��P0���(��+#տ,�{����ՓOU�XD!L��&n�}P��US�*�L���(�`M�m1�^�V��m��o��F��`��2�Y��P";
            break;
        case"ro":
            $g = "S:���VBl� 9�L�S������BQp����	�@p:�\$\"��c���f���L�L�#��>e�L��1p(�/���i��i�L��I�@-	Nd���e9�%�	��@n��h��|�X\nFC1��l7AFsy�o9B�&�\rن�7F԰�82`u���Z:LFSa�zE2`xHx(�n9�̹�g��I�f;���=,��f��o��NƜ��� :n�N,�h��2YY�N�;���΁� �A�f����2�r'-K��� �!�{��:<�ٸ�\nd& g-�(��0`P�ތ�P�7\rcp�;�)��'�\"��\n�@�*�12���B��\r.�枿#Jh��8@��C�����ڔ�B#�;.��.�����H��/c��(�6���Z3���Jjp���K\n��b����,�93�`�3�I�����t4:3��@�+��ﴡ(��r�?P\n4�CʰA@PH�� gH� P���3j,;��<p+����C�0(����(\r�#���7\r)CJ\"'d�(Ni�|�4H�\"�1R\"�R@�\nZ7�.��Њ+x\"\n63Z��Ъ3��6�c^FC��	@t&��Ц)�C �\r�h\\-�7��.�Ue\\�Cd�6(����0ؽ����bJ���P�7��� ,pƫ�c�̡��[�ZX��6/acj��P9�)�)�B3�7�p�d6���1Z�\0�(�l]�9(���b��^��j�z*6�B���K�*^ 9e��Hë��X4<�0z\r��8a�^���\\�)���/8_\r�#��D�p^�R�:/c8x�!���m\n��(:X�S�A�:�ξ�V��4[��i�0�j���c��?��S�pA����o���p?�p�tE\r!.���N���/���\$�4\r�����9��7��9����C���1��Vz�rn/\n�����N��;��;��ldɸri�A?��~�@uk,���fRٌ\r8���:N\ra�Na���sL�R���R�M�,i�뫀�A���D���4P�dS��I��c�����g��4����0t)�%���C��K\n�-2(���a����������Ę�NI,n쫳#q��{\$��;��ù�a����`�ĀE�Г�lJJE(�yT�kQa��gq����֋�4ۆ��Z�R'�\$���d���]'!����y�u+h3 �<�\\	3��1���q�K�7�ج�PO\naR8���{O#�\n�4�;%�Gê�NH�d�b6��yjq��\"�ډqF*2�s2y\"�; �ɄKrV`N))Dq\$:��Ba[C��`��hqe�ٌNX�<I��B��O%[�EY0��-#0���&K)YZ��(�SHi56>HZ�-��|LU1Y��>��K�\\I\\&�O�����AZ\r�:�N�	'�\\�\\�\r)�W3U�k&�\\b��ZoL�*�U�3WI�?C��:� �B�T��!�OS��=P��O'�~�Rرv5sQ�!ay���j��)�f&Dɗ`�W��+�Ր���Z�P� �4�}q�\r8��j��jI�l*k���	`\r��!Wo��B잦�V�I�L�X̟`��|D��V4���W��R&��x4J���^X\r�<*Y��#�C�Y3�PЇ*��9V�\"#)L���J���s�\0";
            break;
        case"ru":
            $g = "�I4Qb�\r��h-Z(KA{���ᙘ@s4��\$h�X4m�E�FyAg�����\nQBKW2)R�A@�apz\0]NKWRi�Ay-]�!�&��	���p�CE#���yl��\n@N'R)��\0�	Nd*;AEJ�K����F���\$�V�&�'AA�0�@\nFC1��l7c+�&\"I�Iз��>Ĺ���K,q��ϴ�.��u�9�꠆��L���,&��NsD�M�����e!_��Z��G*�r�;i��9X��p�d����'ˌ6ky�}�V��\n�P����ػN�3\0\$�,�:)�f�(nB>�\$e�\n��mz������!0<=�����S<��lP�*�E�i�䦖�;�(P1�W�j�t�E��B��5��x�7(�9\r㒎\"\r#��1\r�*�9���7Kr�0�S8�<�(�9�#|���n;���%;�����(�?IQp�C%�G�N�C;���&�:±Æ�~��hk��ή�h8��@\$2L)�;̼�\$bd��K�����;U�K�#\$󜖼1;G�\n���\n5P#�KX�J25i�j�v���[���[lK�G�z��\\wXb��Ԃ�!�)�G[��x�S��rhA	���2A�M��{�G;���H�#��jDUi)�W��2���}�h�襡�㲨�풨Z����E��X���\"�\$e�T��/=��F���h4*��_�Nu�/p��kܸ��SWdZn��g���E�\"��k3�^(�ڪh�O�h�Ѡ����\0P�(�hY;`��| �\"[���6����P��\nD\r���O���-F��M�DN�����Y���#�\$ٶ����o��]r�\"A�d�΄�H�7>�(/s��RQ�[�;臐nY�@H]_]?���Q�b�ni���l��0�v�^?,�������<>G7���O��&�_��)�h�����NS�|��ɾWj��A�shX;����K�Go�f��[�aEM��̨�k3ȵd*�&U�S\nA�w�|��jg�?!�NI)P��#�Y\n�ubDt�����#�d�ƒ��K�AP4��2b��7p@C m\r!�)�@Ӓp�H��@r��� ��p`����!�pa�1�)��zn�9�Cp/@�J&I/A�/ �:'gp��kS��r�}�&�|]F�H4�W)�П���E�Ɗ��R�x���@�+����c�<G������DH�����2e5���&\$�rʀ��x�`Ҳ�2�Ә�H��sp|����>���/u,e_�QX\r1NsR�+\"�&[%�5o���TDt,%.%���r�4���^	J0� �V�aɵ4�0��ea�3ZNxg�t�4�@�*2^KT�7Ǩ���a\r�̺�Sʑ�;�C�����\n	)�&'e���~���{����TS^c�CS���c��\0����Ӕl��3@��r\r!ڒ�P�L,BU��,��R�ޘUR���U��0��aq,V*,+E\\�U��������waۄ�RAk��[�vҪ��4�:��<�	z�0��)uO��J�W��9!)r�d��i	Q,'�%�#�T���0������M�5d�U����T(��\0cb2\r�\"�%Jc�1D\r��BN�\n�'�qU���5�y��o��҆ӳ�fM�:��Z`뽕�	D9X�\r��\0P	�L*L��˝�����:'�O�1�E�������g�*�b@�1��f�8M�L!�����V��)� ��TG�j���K8��r������:��q�t��0�!�9/���\0������0�d���vX4T��l2v�W@e�K�ִI�K��(�\n��Jv�g=�2�޽I���r�x@��%~�u��#,�^a�����h��5���-�p��ذ����ɞ�j��k��v��Ql6%KQ[��Cq���RCJ��v����#���ti��������i}�mȤ-b�7��pյ�'X�80B\r�\0U\n��UPSܞ�C��d�Ӝ��i�K�9ŉkW[<�Sm�V�y.`zk���gX�5��p �]�Qj\"�E�5P�K�M�-7ghC%NL�2&G�L���ć��1'�\0���ʣ����3�Q��5ċ�}g�k�_�G��4��w����)�*�-�E�]�rBK�q%�,�##�2�b_���\$������52>B��A���_=R�g��?L{���nH�&��){�i�BFD�M���[�cb׏����9��}�.S���]�6��@J��۷H��E�bP";
            break;
        case"sk":
            $g = "N0��FP�%���(��]��(a�@n2�\r�C	��l7��&�����������P�\r�h���l2������5��rxdB\$r:�\rFQ\0��B���18���-9���H�0��cA��n8��)���D�&sL�b\nb�M&}0�a1g�̤�k0��2pQZ@�_bԷ���0 �_0��ɾ�h��\r�Y�83�Nb���p�/ƃN��b�a��aWw�M\r�+o;I���Cv��\0��!����F\"<�lb�Xj�v&�g��0��<���zn5������9\"iH�ڰ	ժ��\n�)�����9�#|&��C*N�c(b��6 P��+Ck�8�\n- I��<�B�K��2��h�:3 P�2\r-h�\n� �-�~	\rRA\$#�@ؘB� �����+�!K+K	��	�Bv�7c\\J��\0Ă�L�9N���8�cSZ;C�T4`PH� iD�/�П��P5��*�����a L�#&%�( �c���\$\"��Z>	�\"�3Ēq}*�\$|:J�@4F���1�oVQ�l�2գ\n>60�4��a�3��W\r�-���(ݵf:Vs�h��BR�\$�Ԡ\$Bh�\nb�2�h\\-����TUJ �D�d�3�J:�\r�0�k�\n�������P�,��7�/X�<��&:�p��9�è�\$�&5��H0������Cj�:�A@��\"r3Zٍc����)�pAa<6�dȘۗG\0�ѹ)N5+�2�����+\$#�Ĺ3C�R*4�W����(7�\0�].��h1�Х*���H2���D4���9�Ax^;�r��#�\\���zr�I��\n��xDt�O��x�b�_P�+[��9�ǲ+*d�1@��k�@�~\n(8EØ�����4�UΥĄ_��<�+��<��tS�0�-�)��6�	�|7��g���F�S�!��\$T��9��������akhP� �Q	�7'+q����C�B��;��^ڠ8ro�8�̼c(eL��3\0�̡\"E\r�T|�R�ཆ��JK�{/�`���CrgA93����J�p� ��b��xd#H\0䮈v��N�@�\0PS� \nhX�B�\0M)���8�0�jͩ\r�����@��Sh�-��\\�1L\"p�\0���)�\"���!�@��=.���&'��Òq��t������)��0���JV��R�\0�A��z�i/&,����	I�fm�\\V� �t��j嬡<tJBI&x\$D�h� s')�P��C�����\0\"����<i���N(y ^��%!@�\nծxI�>(p\0�¤�a9����D�m\$�=M	�S�o�e\$����\\é���5Mװ���Ld�8�M�h\ry /��10@Lk|��,��P8!�8���'�\\�!�\\�O��drr&�d<��]�rm��L����w�HzyUa\$T�PiD�����BJS�l:�EKU\"@����!،FbR�\0la�k��H�Y�8��U�'A�j����\"R���oR3��0-�78D��%�Ǩ�M?������mFKQk-�V�l[��0�;h�\$�����a���n�_���KP\nK�#h�����2a4���̍+Y5��+F�JHѡ�\$�(�OȾ��I�OĆ��HF���j�m7F�y�9)	�����'�r%�e���L�%#H�\\���R�͚QY\$�fp�{3(�b,@PT\0S�����`UoZ�\0���r�#����os�Y�:aR�4J�\"40���c�";
            break;
        case"sl":
            $g = "S:D��ib#L&�H�%���(�6�����l7�WƓ��@d0�\r�Y�]0���XI�� ��\r&�y��'��̲��%9���J�nn��S鉆^ #!��j6� �!��n7��F�9�<l�I����/*�L��QZ�v���c���c��M�Q��3���g#N\0�e3�Nb	P��p�@s��Nn�b���f��.������Pl5MB�z67Q�����fn�_�T9�n3��'�Q�������(�p�]/�Sq��w�NG(�/Ktˈ)Ѐ��Q�_�����Ø�7�){�F)@������8�!#\n*)�h�ھKp�9!�P�2��h�:HLB���0쏡�[��5�맍�M3I\0(2��\0��P�֍H�&4�Pp�7�̘�2Dâ2b:!,�-\rK��/�cL�,�r�<�@R���\\��b�:�J�5�Òx�8��K\$B`�\r�p|Z��Γ��/�(Z6�#J�'��P���|~�<,�(\$%p�T��؅��<�2�t���5\\��>U}cK*բ{[\$Û%/>��tW�S\\4U�͋JR҂^=%P\$	К&�B���p�o[�.�˫(���\nZ\r�@�1���3�Ҡ�E*E�Tą`Ȣ���R�p��@#��1�C��:��@��!c89ac�J�\r��\r�êaL\rN����\r�k�!�b��#�S�C246��@�O��֎�|�&1��9��B�%��y���@Cp�2���cC	�P@&�`�3��:����xｅͶH������x�%0��A��\$��x�!�UEٯYU�{C���C(-\$���)x� :��c�5W��ҽgc����o���lc�9p|+�\0@P'��H�82�0�:r|���ʣEۘ��� oV��1��&��n9Ũ��,��4J7��z���0�@�c\$�u,�K��Mi%���ia�@9�&(ş�����fA��\n&��>��GÙ/D޸uܚ�yu9|�BIVd.%\$�(��r�  ��L���o7���4T �|�����t3f�ȓ�>H�Sed�!&s؃U�ٙ���؁�4d�L@݃�I`;�@Ƴ�gnid�A�FZy.&ȚҌ��\nZ\$�(D��Ca�7\nG�C4�������� \"2蒄�Kg藄�&LY'\r)`�������8�S4O�1�#�����<r ~�.:�2҈)9'fJô�o	�P	�L*3���CQוrBI�҉\$ǀ��T�@���A�a혙b�a�\$�p�[\0S\n!0e,@�7�R ����ѡ?|��@�L�2�JiUf���e!\0n�m��z�J���Ti*\"s�#ñ�F�O=i.�V\$���\$�:j}��.k:�%U{O��@>�a�����Jȩ��T��#��zJ�H4PXk'A�ړ��Z	����FH��A�O'�\$�P��h8>�����^\"I\"��,C\r>@U�2��+��a�(c� &��mf���X��a,Ցeo��UCgG�I�.��\"���C0y,�ؘ���B�v�)09���Zҙ�}���\\�'eK�2����q�-�����������]slt\"(!jh�˰ 5��4�c�-�)��t�|,���&�Z���PK\$1B8��,�	)���xv@��.��4\$kV����g��\"J\0";
            break;
        case"sr":
            $g = "�J4��4P-Ak	@��6�\r��h/`��P�\\33`���h���E����C��\\f�LJⰦ��e_���D�eh��RƂ���hQ�	��jQ����*�1a1�CV�9��%9��P	u6cc�U�P��/�A�B�P�b2��a��s\$_��T���I0�.\"u�Z�H��-�0ՃAcYXZ�5�V\$Q�4�Y�iq���c9m:��M�Q��v2�\r����i;M�S9�� :q�!���:\r<��˵ɫ�x�b���x�>D�q�M��|];ٴRT�R�Ҕ=�q0�!/kV֠�N�)\nS�)��H�3��<��Ӛ�ƨ2E�H�2	��׊�p���p@2�C��9(B#��9a�Fqx�81�{��î7cH�\$-ed]!Hc.�&Bد�O)y*,R�դ�T2�?ƃ0�*�R4��d�@��\"��\rD��\"M���Ӛ\"�=k!|�5Ht¦��B�:��1:<�!D�<���i�:ۨtCn�&4����#>�HKR��-CUU�:p�R&�[F.`PH�� g^�+]��LYf�\$��\$� �:[2������!'J&��\rd�fh�p�5\n���>�2)!*��Ժ�DT)!=[S��N�\$�\$�Q7�ޔ*�}Ww2*�,e�ں��Ą��\"x�K]XbD��8Z}����\"8�ߋ�xb/����%�,��?����3��\$	К&�B��� \\6��p�<�Ⱥ�\\�m�ᕲښ?�`�97-�@0�N�3�d\$2�*B0���mHS����\r��<���:�c�9�è�\r�x�	ac�9o�0�A#�������R���nh�l!�b���&�qi��I�J�%����j�h���x��ex�5�ڻD��,\n��T����\$�a\0�2r�ta�r\\�2F\0x0����C@�:�t���>��Fc8^2��x�%��W����G��	px�>-kQ\r�xk���E���Q=Q�h�;\"tDK�1�ء��θr8��9�tf�R(p\r-��=���|ϡ�>��߃�z��9?g���3�I),�\"��Hm,6����J:9�T��JtAu\rg4�C����\r�е�Ť�K�pQP�&\"b|a�cHm(25ʂ��7,�	���\"K��80�pC�0y��*�P��I\"o��9��3���d����U�E`�C`s-fa��T[L�qS�I�zASm�a���n!A\0P	B[5f+.JZ�/%�ڥ�{I��(A\r%�iN��8� ��ʩC�3�<� ������'>�Mb��@� �	)��9�9�	q١��¹;����h1���C;�>R��^{h_)yB��<FX�54��*VI�r�J�����[��cP!�CBA#qN Թ���yh(A\$����J�8q�9���v�{a!��F`̌�k҈Ov�\"���j�����*H�	:!A!@'�0�0���&l.��FC3�U+%\$��ǙpL�%C�M��Ԃj,�!-MsY�(�z��t�ˆ�WcI�\r2M�-#to(�.:n���7F\0S\n!0i�K��Rf7eJb��rUz�\$`p��E��5T��\"3�[���It2F��k�(n�qGw:���BP��>�b�B%�L�:b�b�*&�Ȧ�O�Z��K}J�4>�R���cf�[\r���!tA�6mZɗrT\n��P���\0��m�kό�qȅP��h8G�f�!;�𘴻5�O�3�����-��\\kw�őS�L��|���s�Ҕ��W�y�\\��-ץ�AH�\n	�x4�`�c˫9U��C\r�d���F�l��J���܊�y��ʮu�e�	c�+�ꁃʈ��Rr�kŇ�CA��y�U�X�P�f�m,�ɿ���.�\nR�8��c�qѶYL2��9� �<����䬅��5ا�5��xx�_\"���h)*���%n\n\rR�]��>����";
            break;
        case"ta":
            $g = "�W* �i��F�\\Hd_�����+�BQp�� 9���t\\U�����@�W��(<�\\��@1	|�@(:�\r��	�S.WA��ht�]�R&����\\�����I`�D�J�\$��:��TϠX��`�*���rj1k�,�Յz@%9���5|�Ud�ߠj䦸��C��f4����~�L��g�����p:E5�e&���@.�����qu����W[��\"�+@�m��\0��,-��һ[�׋&��a;D�x��r4��&�)��s<�!���:\r?����8\nRl�������[zR.�<���\n��8N\"��0���AN�*�Åq`��	�&�B��%0dB���Bʳ�(B�ֶnK��*���9Q�āB��4��:�����Nr\$��Ţ��)2��0�\n*��[�;��\0�9Cx�����/��3\r�{����2���9�#|�\0�*�L��c��\$�h�7\r�/�iB��&�r̤ʲp�����I��G��:�.�z���X�.����p{��s^�8�7��-�R�,er*WR�--D5}h�/5�l\n���F�	?/�*�e7֚J�d���茙еE�p��D�]�BrTWT��ʊ,�W,2��h�Z_�c\$dܶI@�U��W6iLr�*Ԫ/x�A j���X�)�*���y\\L��\r��������#Q��;��\r���%̥��\rc!T�r��)(;A.D�U��ֱ	<���\\��Ֆ��-8N��Ζ�m�#�ِ�uI�;�b�Cˑ�Ӌ|j��(��ޮڒճ�����m����v/��y�ĠZS���C��\nȸ�wX�q.m�]lt�B@�	�ht)�`P�2�h��cϔ<���\"�q�\$������kt��ENۺ0�O�3�d�2��\"Z*��\$��;�9\\��ˉ�B\n�{�Cn �:�����a�:��@P�:H`���(C8aI\0�\r��@R@u>�9���R� ٘d\$���{��/w2���g}H)��\n�T��D��ȶ��DZ�L}-h��p���\0inug�����E&�W/r����)T%x*��|2s�\$�\0�!\0nL�P1�%\08 ���>�Ah��80t�xw�@�����Pg�7�Ƞ������It�@g��0��p��(�/,�h�ʺ=�R����[�� \"0�Ѥ�\\�X�C����/֣&�+�40�3��4�a�51\$�K���=G������DH��##��MrFI�T���������i�b�\r��Q�T��0h\r�H�A���i��3��>�;P�2��@���Sz�짡L��kA��D&�� h<A�1�������C��bA�3L�A�Hs�p6��\"�i��>4���ڒ��0����{G�F\$ҧ�(���k�4���o	h\n\n (�.Ў}\\�5d�ĕ���ـ��ZV�N���-�'��s�z�hebA�5C�~�o�uT��{�T�Y�&[���mo�<��~�)SჇ�>0�K(Je?6�8B)�P��rbA��0��Hg�@��T���k}\r���)e-F%NU� �Z��<Q�n�� �\$a��\n�KE8�m0\"\r�}�I)�!H�ԗH(@�Ƃ�Xו\rr�O�^��tɿ�>�	vU��\n�d���G����4�#�B��n����>�O}ɤ6������L�����d-y�80g!����p(���W��edCv��齉F&�4.��LF���K\$&�K���0�4O�n�:�)3K��G���E�I�Q��)��+��J	C(��>+��Q	��1��0T����Oc`�\"Ą��H���Rb�mRy}��rwr깃pCrrT�M�ed���M�Z��Y�8��1}�a�j<���@I>ᶽ�vܓ��^�yi�ek��>��w��iȩ�c�r�my���}\\�H�:�#�ݒ�,�����:�݁��(6�XCkO)�>j��,\$�a�3@:W�5����X6B�F��:G\\(�J��:a�B��r;9D�>[l��ſe9kl�m.X��s\\jXٞ;�o��GPd�E�	������Q+�Go��Zܴo&���H6�u.!�܉Mk=� �`��|Ǯe����o�}�Z����\\�dCK���x�:�\nA�6ft���>훽zce;���s׳7m�wRɜ��W��]��:�#[%�\\[��H��(&F\$SQ�>���ziB��P^͚�66A�E�_�	���7א�a*��d����F��kK���r�|���\$���v\0C(q�p�hi?\$�}�'�G�9/B����������h��������3JH�\\u/�7#<�\"�:��]GR��XC�����]�";
            break;
        case"th":
            $g = "�\\! �M��@�0tD\0�� \nX:&\0��*�\n8�\0�	E�30�/\0ZB�(^\0�A�K�2\0���&��b�8�KG�n����	I�?J\\�)��b�.��)�\\�S��\"��s\0C�WJ��_6\\+eV�6r�Jé5k���]�8��@%9��9��4��fv2� #!��j6�5��:�i\\�(�zʳy�W e�j�\0MLrS��{q\0�ק�|\\Iq	�n�[�R�|��馛��7;Z��4	=j����.����Y7�D�	�� 7����i6L�S�������0��x�4\r/��0�O�ڶ�p��\0@�-�p�BP�,�JQpXD1���jCb�2�α;�󤅗\$3��\$\r�6��мJ���+��.�6��Q󄟨1���`P���#pά����P.�JV�!��\0�0@P�7\ro��7(�9\r㒰\"A0c�ÿ���7N�{OS��<@�p�4��4�È���r�|��2DA4��h��1#R��-t��I1��R� �-QaT8n󄙠΃����3\0�9��L �q1�esWs\n�ؼ)�2���Ԝ�˥gVSh�ڋ;��Đ���+��Y�I�9O�͍�][��\rCN�*���Q��+�u/������3�\r%ʈ<��S���^x�b��M��iTP�8�ӥW��j~�+�,�l��܅�Z�Ä���fY*��W�7XK,,Y;��؝���[�6��[H���*\n�����q��.����Zʤ��Skl{�hq��S�n�����H\$	К&�B��L���)�~ŜhHP^-�e�j.����4|[��P�:@S��#��7��0�*��+�E�We]db��IZ]MpGMȨ7�Ch�7!\0�C���c0�6`�3ʣ�X�^�3�2�A��(�*��(P9�=R\0���#���R@@!�b���:����m�iWl�K�_ټl�0�Ӥ�A�}�f �h����w��.�N@*]p���b�\0PT=����d�T:V2=�ܛ��cQ*2&�@	�tA�� ��p`�����pa���9'��(n�D�E�>���:%P�xa�`)����_k.E����d�E�,c��Z����Wz�^(�ܰy�z��h����C�G�D0�X*���@]\r��h�p���b8w�1.����PP�EC��^�@>	!�8��C�`�I�Kt�)����5����nwм7F��\n�(��'��ƳHP ���V���xaquD�\0�~`b=��7B`�-�(a�(7�����y�9�&�΁��h=��0�p@䬸\r!�63��N��CO�\\(�hsV�?g�����v)Ң͊���V��P	@�\n[+�.P���\0w��Y���R�����/��}��?A�����	>�dPǜ�br�������ҦO�o�'D���9a�qLd؁�pp|22nH���C�a�^�����'�1�P�ZQ\0e�v����xV�lg���x�J�Rr�t�c�l *�9�m�	���dulI�����X	\$�<��@K>3 9����!��L�̜l+��ڸ&�����U��դ�W+\nY�GJ��� (+et��[B.��]��l�x�i���Y�\$:MG�j\"�e��:|[�q������ڗJ�Q�^�-s�m�*l@/:%r���\n!0j��9�R�;�\ne�O{w�OT�{���I%X�t��`��m�>i��8���s<'�cE׎��;	�~dUL��.6D��[Q�<�rQ/k�\"Aܞ���g�v�K���A������\n�xia������z�Wh��Ұ��m�\"�=��0-	�[��V�;i5Gf�.�c��#,QӬZ��� v4&��Y���VCL\0���].�!}���X���8���8WD�vH�^�5�NV\ncK,�����E��9)\0.2/lSM,�L�`˂�24�&�*S��@h,nX��n�[icp��%���X�gH�](��)��u0��FZ�\r��+7t�2�Wt�P�Z��������Jj���6�ؙ�1�md�";
            break;
        case"tr":
            $g = "E6�M�	�i=�BQp�� 9������ 3����!��i6`'�y�\\\nb,P!�= 2�̑H���o<�N�X�bn���)̅'��b��)��:GX���@\nFC1��l7ASv*|%4��F`(�a1\r�	!���^�2Q�|%�O3���v��K��s��fSd��kXjya��t5��XlF�:�ډi��x���\\�F�a6�3���]7��F	�Ӻ��AE=�� 4�\\�K�K:�L&�QT�k7��8��KH4���(�K�7z�?q��<&0n	��=�S���#`�����ք�p�Bc��\$.�RЍ�H#��z�:#�`���H�\r;ҀX�i�(@�|\r\r�(��Ħ.8�0��f,�!\0��0�Xț0C����)��w:a l����B�\r�N1F��<��j\n�0�#Jԥ++,匬����\r�H�<��N꾹.��>�����O�.��tJ@��\\�0��-9���\"�������{�)�B �h��<�Ⱥ�#Z3��P����N\r�\0a��j>6���ʟi�V=\$��7�}�C��]��X�8@3#��'c��܌,�ڋ��rD2�ˠ�8'�\n}J�b#�4�n���C[��]�+�hCu�<�4a@�)�B0R\rL�2J6�c.���N'ܷ<������q�n�^��Ȁ�ϰ����Ib����G1%��ˏ\rk���%�x����3��:����x﭅��h��(��!zf���K��A���+-�8]p#^^,��\"�}����^:gP��`@6/�̘��F�N�^��N �!H3i�2���u�Ì��0����ZX��e�f���n���z����c����[Ų\r�#���^HD���j���6���HY÷gp��ܣ��ʩ������}ic�\$�Aa9\$\\S�St2�L�`Θ#�[\\��AB,����H�^��5��FpN#�m���H�!2p5�p���r=vԉ/HWq\n (�P�P�]��V&�L�d#����\nT��lsa�2ض_RH*l��S\\s��O���E�A,%�d��v�~����b@��'\n��?���EØp&L̐0�#�p*�V�rJ�úah,��v�M�tw5�:�0�I�I+ ql�B�Mn�\"iZgL`&8�@�l@#���@����'1Q��>@@^#5��H'���Ό�`�؞���C�P�7u���y/`(�\ri �*J���Kd�^ED����&�#��J��C:�v(�75�v�c�A*B�H'z�SFi�c�L*\$�0���/I�)�߇5��C�d;ff\n@��p�a4D��B t�i��t�xd��(TT�X�C�I��Qi\rW�%T�����RjL�Q�L���,'�����p��2>��\0CD��\"�'fi���*�@�A�B\r�;5�F�DG}e�ӺYT���1�	{��%wLU���b[ˉs��l�LD^Q\"]A̽�!�ʆ�\n�����������]�'l�͉��QT��'h��*�K���¸�t�e�,۴rt�Y�\\\0)����^�N�ڞ�%0g�,N�1P����3�m��\0�G�t`8�~�����=p�3��X�yOP2h���>KH�";
            break;
        case"uk":
            $g = "�I4�ɠ�h-`��&�K�BQp�� 9��	�r�h-��-}[��Z����H`R������db��rb�h�d��Z��G��H�����\r�Ms6@Se+ȃE6�J�Td�Jsh\$g�\$�G��f�j>���C��f4����j��SdR�B�\rh��SE�6\rV�G!TI��V�����{Z�L����ʔi%Q�B���vUXh���Z<,�΢A��e�����v4��s)�@t�NC	Ӑt4z�C	��kK�4\\L+U0\\F�>�kC�5�A��2@�\$M��4�TA��J\\G�OR����	�.�%\nK���B��4��;\\��\r�'��T��SX5���5�C�����7�I���<����G��� �8A\"�C(��\rØ�7�-*b�E�N��I!`���<��̔`@�E\n.��hL%� h'L�6K#D��#�a�+�a��!Q*��14M2\n�f@��Z\r��>ɫ)�F#E(�-�.���;r�F��R���J�2��z&2 �ė�!-qWl�{_�S�\"�@UQ6�It��pH�A�,�\rYt�-Yh����4Ѵ�I��kA>�HR�F�۪�S�h�0�-t�ZA�J��?�m�8)�C),��]��K��H�x\"�+���Z�W��-���Iw!�x\\�8������C�����;�S�C�Ay>Sb�cw�K���_���j�f�y��1��h�ɠI�F�K�j�QB�)��]��p�@ �y�״1q%��6���c��\r�0�6D*�5=��\r���\n�{�}���@:�#��1����:��\0�7��\0�:�0���oha\0���P9�+[5���Yb��#3�2^��&�\$BF���b�F��zlD�0\"V[�h\n�Ĺ�/cx�'�[���3hx*8���3H�����Ս��@1ʒ�����q�f��4@��:�;��\\_�}G��3����xdJ�u)��D��G��3��^A�A�ܫ4ڜ�q�*ix���@��B�yL���Q`��s'L=Hñd�R��y���!�( ��M!��#�ØwG��'\0���#��\0002�(	�D\n��:?Dr���	9(%\$��g�\$6��`�t�С!���xz�;�0���C��G.2@¥XWD�`�Mw�5�TG%\$M;� ��A�!��@@΋�G 8#����!�*��\$���si�:�`x��#�@\0�\$i!�9�#l,! �����Q�Ѿ?�\$�5\0@@P��M�g7�P ���I�q�[��GD��#�)Q�ܸ�� ��!Ğ4��ed\$:�,��t�*��:c�rC|��nl;љ�B��O{jl��j�ir�\$�ʄs#γ�a�U��nx)�pu�^`Š���a����A��' 1��ߓ7'ػ*�Q!{�i���o^9H7����cB\r]&bM<u��Y�?�pСC�nJV�So�V��OI'@ҮT�p^E��Èu:�D3#���`�����77d�M��P��TAph�6�R�SE��L\"�s��\n%v�DB׃һ	r�.�\$�r4m�3��';r�+i��>����yP���[jH	q8*h�F]����U��7�U80�\0f����?����\r��4��8\$���a�tz�SZ�W,�|=������V�s\r�˨�M�qCX���\rB���2<VF��&�nbb��n-,��2W1N>u17����2+=Ǚ%�c�\\�J�wA\r���WmJ1�2�:��h�k̎ Y�>�d|z�޹:\$������k�5I�P��h8H���\"x�T�?ɷ�d�G�:�Q\$���O�.���^O��}�.�Rx�a��5Z\">0b�=��\$T�);H\$��kdIW�BF��=��?�PM�!�3�I˩aָ���zE��7D�7,���P9�p�\0��c���p�GV�&�'D~l�ٻ\$�l!�!)�I��x}�\r�����������(�{��oY{��w�}f�<(ꠗ�}L��֥�+�7q�3���\na��J�2��v�IdJ�Z�D���P�V��B��T���'{t����\n\"c�M�#B����B�rAI��H��";
            break;
        case"vi":
            $g = "Bp��&������ *�(J.��0Q,��Z���)v��@Tf�\n�pj�p�*�V���C`�]��rY<�#\$b\$L2��@%9���I�����Γ���4˅����d3\rF�q��t9N1�Q�E3ڡ�h�j[�J;���o��\n�(�Ub��da���I¾Ri��D�\0\0�A)�X�8@q:�g!�C�_#y�̸�6:����ڋ�.���K;�.���}F��ͼS0��6�������\\��v����N5��n5���x!��r7���CI��1\r�*�9��@2������2��9�#x�9���:�����d����@3��:�ܙ�n�d	�F\r����\r�	B()�2ύ)Z�����\r#<��pN���r�	�@�)�	Rܘ���A��Qu\$�B<R�(2��\$%l�+��zIE�3��\"�<�A@��LpѪ PH�� gD��YX�n	~�/E,�1�L�H�er�EzP<:�T̜i\$ā�BB��r�2�R�pE�i�pD��h�4���Nl?\r'=b]� T��VY�T1B=��OH�mM��=��\rI#�h�	�ht)�`P�<�Ⱥ��hZ2�P�Z=l�.́Cb�#{40�P�3�c�2�ѩCWE�O;;����ˁ�Z�u�8���|z���C���-[46 %8��GN.RS\$��5<��.]J�s*0�6�\"�n�С�b��#d#Ni�D�|ٝ��RA�SqtU��u���̮<B�:�4E�\\3@ì(�# ۇ�Y��B�#��ф���D4���9�Ax^;�pýo�s�3��@^2B��\n��xDtOF��x�%�&%E��)�ڃn�E����4�06s��*�i+K�nF��U��'\r�q\\g�r\\���ss��\\�=BP�I�)�� �\nd�v�o_e�E�LD6Y���1 ��B�+R�s��\n!fހ�cthXu��ٺ �S�a�I0��a�:����A��t� #��+	pA�ц؆Y�.�\"�d�	���]���h�w\0H�n�H\n�I�<%��LF��7�42��;eJ2�\0�N��������\r�^B��\n[\$y��(��aϲ�%9�#\"��h��:�y��OA�p�6��d��0�f ���Wf	���\0��j*I�\0P��r�i]��T�KTaXbt�R~���h��\\T�C�]�tMJቯ��I.	\$H<�c�S��(!l��MDJ��6���#� ���\$��g�0�2HK�\$%D��\0�¡���������'8\"�H涉�9'g�̨�F唯B�/1X�C-\$ˑ�9��\rC&�2�2xJ(JE�#H�s�c[9�1�d~rbQ�2���6U�\$�l;효F6�֓t��t蘒�K�E���7�EؕyA91\nR�D�\nUۗ�\$��B�Lה��J\"-6G/E���,LjKD*�@�A�[F�a�S�dL��\\U8�fG�\0x_�)��@r��{:fR#�C�.f�4��S6c\r�WÔP�\r�#������]��yb,͔Sj���]�vi�%�\\l��Ji�1��B�¡��D԰uR��\$D9\$�R�b6���3PXC����ƶ�E�[Q�AI]3�iD9�-\r���+�/�P-�	���&k���_��`�";
            break;
        case"zh":
            $g = "�A*�s�\\�r����|%��:�\$\nr.���2�r/d�Ȼ[8� S�8�r�!T�\\�s���I4�b�r��ЀJs!J���:�2�r�ST⢔\n���h5\r��S�R�9Q��*�-Y(eȗB��+��΅�FZ�I9P�Yj^F�X9���P������2�s&֒E��~�����yc�~���#}K�r�s���k��|�i�-r�̀�)c(��C�ݦ#*�J!A�R�\n�k�P��/W�t��Z�U9��WJQ3�W���dqQF9�Ȅ�%_��|���2%Rr�\$�����9XS#%�Z�@�)J��1.[\$�h��0]��6r���C�!zJ���|r��򽯧)2�=ϙn���I^C���%�XJ�1��2ZK)v]�CW!� AR�L�I SA b������8s��rN]��\"�^��9{*�s]�A�0��E18\$seJ�J�� t�Er����)�C�H�p]�%T����G�4L~��	JR��nYT�I\0@�Dt���B@�	�ht)�`P�<�Ⱥ\r�h\\2�EF2�ŁC`�9%��]���~rD3N*QCF�I��LN��'Ai�����4�C�yn�U�At�Ka G\$:6W�K�\$Ñ\0�)�B0@���9F)N�o����kU4g)��dA!A����w��!>tL��6�#p�9`�@gA2H����]����\r��3��:����xﱅ���ap�9�x�7� �7#�ӹ��|�3a|�AX��IBZ�\$�D�!�^0��r0^N�QYߐ���d��e!��̅Ǥ	���< �jZ���kZ潰l[&͠hC�նmۀ�<�x���dO��\0�܃�K'1fJ���\\A�Łpr\$)�F�~B�� ���*W��1(W���\$V��1&F��	�1�v`��p�b����r!(��Mϯ6E9udHȉ��D2�>����8 \n ((0�U;�\0���BF�5&�xO'�J��z&Ps��^���0�DD@�b�i/�L��q����.gЖd�(�E3��̗\"x�Sb�\n��B&\"qkE\"����l!\\�/_�ě�t�0��Y���B��(��P)���p��7�؎g�ᡲun�E��sh�B�4+ߣ�q(��\0�¡�JF,���Ѹ��H�d�|�؀{�\nB��!S�w�D��IED)\$�@9WR��P#�P��'�XS\n!0��^I�q.]+����՚ 9�dR8as\0�axt��̙��;��螇\0�ρ6+�9WU�l\\\n��ADx���X�W�cD`�D�<!���oYR(��O�B9Db�n	a\\��ɍ\$�4r�7�\0�U\n���l%�-J�Jy�c��Q*-F�54]�]'��D	���L�Jb� R�77e�#n_GH��ړR��H�B�tؼf���[���ps%�Eĸ�0�Z\"Ds6\"NE(z�J��g,��B��Qм�%��G�h�jM���%D5��I��X�)�";
            break;
        case"zh-tw":
            $g = "�^��%ӕ\\�r�����|%��:�\$\ns�.e�UȸE9PK72�(�P�h)ʅ@�:i	%��c�Je �R)ܫ{��	Nd T�P���\\��Õ8�C��f4����aS@/%����N����Nd�%гC��ɗB�Q+����B�_MK,�\$���u��ow�f��T9�WK��ʏW����2mizX:P	�*��_/�g*eSLK�ۈ��ι^9�H�\r���7��Zz>�����0)ȿN�\n�r!U=R�\n����^���J��T�O�](��I�s��>�E\$��A,r�����@se�^B��ABs��#hV���d���¦K���J��12A\$�&���r8mQd��qr_ �0���y�L�)pY��r��2���v���i`\\��&��,��1�IA+�er2�:�@����r�0!pH����H��re��B��^�G1I��'���h�zNR	q�7'����A��l��1�C�N�qA��zBT�q^B�9t��o\\�,ȡ�5J]���_*���\$Bh�\nb�-�6��.��h��%3M�d;`��C`�92�A�M�L5̱�^K�� #u�~�o�pR'1*K�H�:t�\$r�M!�a�U�jM�D�I ���a�C��ARS?�D&� @!�b���x�2��&E��kQ&��Rb���\\�@)�_�ֈB�AXN�S� ��h�7��#��s�r�|��ZH��@4C(��C@�:�t���:�����x�3���^2\r�p�:\r<H^�1H4E�D^\nK�9lYK�\nD��x��P�2�c�7-{��&��g9��-^�|�%E�e�a�#��{n߸�{���{\\�(�4\r�w)A�oAŉ+���Y,\\����Wh6�)ʤ)�F̷W����~!R�B� c��h�A�4�'�`!�kE�����&��8��sa\"��X`C���Q>-̣%#h5�&�Lq�P��a(hDx�e �(���!`�BI\nG.R��*D��T(�P�� Xq�\r&����:\$G@�-�T<��K�Id|V�!p \rh��s\nx�MQ�4�A��̛��Uh8J���(`ڸ-��MŲXx��\0a����8҆0��\\1��p(&�^3f(s`��?��S!�'���3,͗XH'���k,�>1b ��8�q���]����\0�  \\�R\n��)�\0�l���lP�k���J��I�� � ��APg�z�>B\0M;@��;\$B�k�Q<\"Q	����u�D������;�ȝ_��ᎈ���</Қs��C��pĜ�AD�\\�XN��Rt�gļS1B�'	�~�`� <!���r���9�O��])��:���I�+��0T�P��h88�,�+���R\".��0�SMaS��Rd�aTC�hM���0�@�0����*,!���PHESR�i�0�%(Q�4����j6)@ Jl���0��\"D����LR�(�\"T;g�R.aF/Iq�_�}(�4�h���?)�d���r�Ws!���`";
            break;
    }
    $Le = array();
    foreach (explode("\n", lzw_decompress($g)) as $W) $Le[] = (strpos($W, "\t") ? explode("\t", $W) : $W);
    return $Le;
}

if (!$Le) {
    $Le = get_translations($a);
    $_SESSION["translations"] = $Le;
}
if (extension_loaded('pdo')) {
    class
    Min_PDO
        extends
        PDO
    {
        var $_result, $server_info, $affected_rows, $errno, $error;

        function
        __construct()
        {
            global $c;
            $ud = array_search("SQL", $c->operators);
            if ($ud !== false) unset($c->operators[$ud]);
        }

        function
        dsn($nb, $U, $J, $G = array())
        {
            try {
                parent::__construct($nb, $U, $J, $G);
            } catch (Exception$Ab) {
                auth_error(h($Ab->getMessage()));
            }
            $this->setAttribute(13, array('Min_PDOStatement'));
            $this->server_info = @$this->getAttribute(4);
        }

        function
        query($K, $Qe = false)
        {
            $L = parent::query($K);
            $this->error = "";
            if (!$L) {
                list(, $this->errno, $this->error) = $this->errorInfo();
                if (!$this->error) $this->error = lang(21);
                return
                    false;
            }
            $this->store_result($L);
            return $L;
        }

        function
        multi_query($K)
        {
            return $this->_result = $this->query($K);
        }

        function
        store_result($L = null)
        {
            if (!$L) {
                $L = $this->_result;
                if (!$L) return
                    false;
            }
            if ($L->columnCount()) {
                $L->num_rows = $L->rowCount();
                return $L;
            }
            $this->affected_rows = $L->rowCount();
            return
                true;
        }

        function
        next_result()
        {
            if (!$this->_result) return
                false;
            $this->_result->_offset = 0;
            return @$this->_result->nextRowset();
        }

        function
        result($K, $m = 0)
        {
            $L = $this->query($K);
            if (!$L) return
                false;
            $N = $L->fetch();
            return $N[$m];
        }
    }

    class
    Min_PDOStatement
        extends
        PDOStatement
    {
        var $_offset = 0, $num_rows;

        function
        fetch_assoc()
        {
            return $this->fetch(2);
        }

        function
        fetch_row()
        {
            return $this->fetch(3);
        }

        function
        fetch_field()
        {
            $N = (object)$this->getColumnMeta($this->_offset++);
            $N->orgtable = $N->table;
            $N->orgname = $N->name;
            $N->charsetnr = (in_array("blob", (array)$N->flags) ? 63 : 0);
            return $N;
        }
    }
}
$mb = array();

class
Min_SQL
{
    var $_conn;

    function
    __construct($h)
    {
        $this->_conn = $h;
    }

    function
    select($S, $P, $Z, $r, $H = array(), $z = 1, $I = 0, $yd = false)
    {
        global $c, $x;
        $w = (count($r) < count($P));
        $K = $c->selectQueryBuild($P, $Z, $r, $H, $z, $I);
        if (!$K) $K = "SELECT" . limit(($_GET["page"] != "last" && $z != "" && $r && $w && $x == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $P) . "\nFROM " . table($S), ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($r && $w ? "\nGROUP BY " . implode(", ", $r) : "") . ($H ? "\nORDER BY " . implode(", ", $H) : ""), ($z != "" ? +$z : null), ($I ? $z * $I : 0), "\n");
        $je = microtime(true);
        $M = $this->_conn->query($K);
        if ($yd) echo $c->selectQuery($K, $je, !$M);
        return $M;
    }

    function
    delete($S, $Dd, $z = 0)
    {
        $K = "FROM " . table($S);
        return
            queries("DELETE" . ($z ? limit1($S, $K, $Dd) : " $K$Dd"));
    }

    function
    update($S, $R, $Dd, $z = 0, $Xd = "\n")
    {
        $bf = array();
        foreach ($R
                 as $y => $W) $bf[] = "$y = $W";
        $K = table($S) . " SET$Xd" . implode(",$Xd", $bf);
        return
            queries("UPDATE" . ($z ? limit1($S, $K, $Dd, $Xd) : " $K$Dd"));
    }

    function
    insert($S, $R)
    {
        return
            queries("INSERT INTO " . table($S) . ($R ? " (" . implode(", ", array_keys($R)) . ")\nVALUES (" . implode(", ", $R) . ")" : " DEFAULT VALUES"));
    }

    function
    insertUpdate($S, $O, $xd)
    {
        return
            false;
    }

    function
    begin()
    {
        return
            queries("BEGIN");
    }

    function
    commit()
    {
        return
            queries("COMMIT");
    }

    function
    rollback()
    {
        return
            queries("ROLLBACK");
    }

    function
    slowQuery($K, $Be)
    {
    }

    function
    convertSearch($u, $W, $m)
    {
        return $u;
    }

    function
    value($W, $m)
    {
        return (method_exists($this->_conn, 'value') ? $this->_conn->value($W, $m) : (is_resource($W) ? stream_get_contents($W) : $W));
    }

    function
    quoteBinary($Pd)
    {
        return
            q($Pd);
    }

    function
    warnings()
    {
        return '';
    }

    function
    tableHelp($E)
    {
    }
}

$mb = array("server" => "MySQL") + $mb;
if (!defined("DRIVER")) {
    $vd = array("MySQLi", "MySQL", "PDO_MySQL");
    define("DRIVER", "server");
    if (extension_loaded("mysqli")) {
        class
        Min_DB
            extends
            MySQLi
        {
            var $extension = "MySQLi";

            function
            __construct()
            {
                parent::init();
            }

            function
            connect($Q = "", $U = "", $J = "", $cb = null, $td = null, $ee = null)
            {
                global $c;
                mysqli_report(MYSQLI_REPORT_OFF);
                list($ic, $td) = explode(":", $Q, 2);
                $ie = $c->connectSsl();
                if ($ie) $this->ssl_set($ie['key'], $ie['cert'], $ie['ca'], '', '');
                $M = @$this->real_connect(($Q != "" ? $ic : ini_get("mysqli.default_host")), ($Q . $U != "" ? $U : ini_get("mysqli.default_user")), ($Q . $U . $J != "" ? $J : ini_get("mysqli.default_pw")), $cb, (is_numeric($td) ? $td : ini_get("mysqli.default_port")), (!is_numeric($td) ? $td : $ee), ($ie ? 64 : 0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
                return $M;
            }

            function
            set_charset($Da)
            {
                if (parent::set_charset($Da)) return
                    true;
                parent::set_charset('utf8');
                return $this->query("SET NAMES $Da");
            }

            function
            result($K, $m = 0)
            {
                $L = $this->query($K);
                if (!$L) return
                    false;
                $N = $L->fetch_array();
                return $N[$m];
            }

            function
            quote($me)
            {
                return "'" . $this->escape_string($me) . "'";
            }
        }
    } elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
        class
        Min_DB
        {
            var $extension = "MySQL", $server_info, $affected_rows, $errno, $error, $_link, $_result;

            function
            connect($Q, $U, $J)
            {
                if (ini_bool("mysql.allow_local_infile")) {
                    $this->error = lang(22, "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
                    return
                        false;
                }
                $this->_link = @mysqli_connect(($Q != "" ? $Q : ini_get("mysql.default_host")), ("$Q$U" != "" ? $U : ini_get("mysql.default_user")), ("$Q$U$J" != "" ? $J : ini_get("mysql.default_password")), true, 131072);
                if ($this->_link) $this->server_info = mysqli_get_server_info($this->_link); else$this->error = mysqli_error();
                return (bool)$this->_link;
            }

            function
            set_charset($Da)
            {
                if (function_exists('mysqli_set_charset')) {
                    if (mysqli_set_charset($Da, $this->_link)) return
                        true;
                    mysqli_set_charset('utf8', $this->_link);
                }
                return $this->query("SET NAMES $Da");
            }

            function
            quote($me)
            {
                return "'" . mysqli_real_escape_string($me, $this->_link) . "'";
            }

            function
            select_db($cb)
            {
                return
                    mysqli_select_db($cb, $this->_link);
            }

            function
            query($K, $Qe = false)
            {
                $L = @($Qe ? mysqli_unbuffered_query($K, $this->_link) : mysqli_query($K, $this->_link));
                $this->error = "";
                if (!$L) {
                    $this->errno = mysqli_errno($this->_link);
                    $this->error = mysqli_error($this->_link);
                    return
                        false;
                }
                if ($L === true) {
                    $this->affected_rows = mysqli_affected_rows($this->_link);
                    $this->info = mysqli_info($this->_link);
                    return
                        true;
                }
                return
                    new
                    Min_Result($L);
            }

            function
            multi_query($K)
            {
                return $this->_result = $this->query($K);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($K, $m = 0)
            {
                $L = $this->query($K);
                if (!$L || !$L->num_rows) return
                    false;
                return
                    mysqli_result($L->_result, 0, $m);
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_result, $_offset = 0;

            function
            __construct($L)
            {
                $this->_result = $L;
                $this->num_rows = mysqli_num_rows($L);
            }

            function
            fetch_assoc()
            {
                return
                    mysqli_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    mysqli_fetch_row($this->_result);
            }

            function
            fetch_field()
            {
                $M = mysqli_fetch_field($this->_result, $this->_offset++);
                $M->orgtable = $M->table;
                $M->orgname = $M->name;
                $M->charsetnr = ($M->blob ? 63 : 0);
                return $M;
            }

            function
            __destruct()
            {
                mysqli_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_mysql")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_MySQL";

            function
            connect($Q, $U, $J)
            {
                global $c;
                $G = array(PDO::mysqli_ATTR_LOCAL_INFILE => false);
                $ie = $c->connectSsl();
                if ($ie) $G += array(PDO::mysqli_ATTR_SSL_KEY => $ie['key'], PDO::mysqli_ATTR_SSL_CERT => $ie['cert'], PDO::mysqli_ATTR_SSL_CA => $ie['ca'],);
                $this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $Q)), $U, $J, $G);
                return
                    true;
            }

            function
            set_charset($Da)
            {
                $this->query("SET NAMES $Da");
            }

            function
            select_db($cb)
            {
                return $this->query("USE " . idf_escape($cb));
            }

            function
            query($K, $Qe = false)
            {
                $this->setAttribute(1000, !$Qe);
                return
                    parent::query($K, $Qe);
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insert($S, $R)
        {
            return ($R ? parent::insert($S, $R) : queries("INSERT INTO " . table($S) . " ()\nVALUES ()"));
        }

        function
        insertUpdate($S, $O, $xd)
        {
            $f = array_keys(reset($O));
            $wd = "INSERT INTO " . table($S) . " (" . implode(", ", $f) . ") VALUES\n";
            $bf = array();
            foreach ($f
                     as $y) $bf[$y] = "$y = VALUES($y)";
            $qe = "\nON DUPLICATE KEY UPDATE " . implode(", ", $bf);
            $bf = array();
            $Ec = 0;
            foreach ($O
                     as $R) {
                $X = "(" . implode(", ", $R) . ")";
                if ($bf && (strlen($wd) + $Ec + strlen($X) + strlen($qe) > 1e6)) {
                    if (!queries($wd . implode(",\n", $bf) . $qe)) return
                        false;
                    $bf = array();
                    $Ec = 0;
                }
                $bf[] = $X;
                $Ec += strlen($X) + 2;
            }
            return
                queries($wd . implode(",\n", $bf) . $qe);
        }

        function
        slowQuery($K, $Be)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info)) return "SET STATEMENT max_statement_time=$Be FOR $K"; elseif (preg_match('~^(SELECT\b)(.+)~is', $K, $B)) return "$B[1] /*+ MAX_EXECUTION_TIME(" . ($Be * 1000) . ") */ $B[2]";
            }
        }

        function
        convertSearch($u, $W, $m)
        {
            return (preg_match('~char|text|enum|set~', $m["type"]) && !preg_match("~^utf8~", $m["collation"]) && preg_match('~[\x80-\xFF]~', $W['val']) ? "CONVERT($u USING " . charset($this->_conn) . ")" : $u);
        }

        function
        warnings()
        {
            $L = $this->_conn->query("SHOW WARNINGS");
            if ($L && $L->num_rows) {
                ob_start();
                select($L);
                return
                    ob_get_clean();
            }
        }

        function
        tableHelp($E)
        {
            $Jc = preg_match('~MariaDB~', $this->_conn->server_info);
            if (information_schema(DB)) return
                strtolower(($Jc ? "information-schema-$E-table/" : str_replace("_", "-", $E) . "-table.html"));
            if (DB == "mysql") return ($Jc ? "mysql$E-table/" : "system-database.html");
        }
    }

    function
    idf_escape($u)
    {
        return "`" . str_replace("`", "``", $u) . "`";
    }

    function
    table($u)
    {
        return
            idf_escape($u);
    }

    function
    connect()
    {
        global $c, $Pe, $ne;
        $h = new
        Min_DB;
        $Xa = $c->credentials();
        if ($h->connect($Xa[0], $Xa[1], $Xa[2])) {
            $h->set_charset(charset($h));
            $h->query("SET sql_quote_show_create = 1, autocommit = 1");
            if (min_version('5.7.8', 10.2, $h)) {
                $ne[lang(23)][] = "json";
                $Pe["json"] = 4294967295;
            }
            return $h;
        }
        $M = $h->error;
        if (function_exists('iconv') && !is_utf8($M) && strlen($Pd = iconv("windows-1250", "utf-8", $M)) > strlen($M)) $M = $Pd;
        return $M;
    }

    function
    get_databases($Mb)
    {
        $M = get_session("dbs");
        if ($M === null) {
            $K = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
            $M = ($Mb ? slow_query($K) : get_vals($K));
            restart_session();
            set_session("dbs", $M);
            stop_session();
        }
        return $M;
    }

    function
    limit($K, $Z, $z, $Zc = 0, $Xd = " ")
    {
        return " $K$Z" . ($z !== null ? $Xd . "LIMIT $z" . ($Zc ? " OFFSET $Zc" : "") : "");
    }

    function
    limit1($S, $K, $Z, $Xd = "\n")
    {
        return
            limit($K, $Z, 1, 0, $Xd);
    }

    function
    db_collation($j, $Na)
    {
        global $h;
        $M = null;
        $Va = $h->result("SHOW CREATE DATABASE " . idf_escape($j), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $Va, $B)) $M = $B[1]; elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $Va, $B)) $M = $Na[$B[1]][-1];
        return $M;
    }

    function
    engines()
    {
        $M = array();
        foreach (get_rows("SHOW ENGINES") as $N) {
            if (preg_match("~YES|DEFAULT~", $N["Support"])) $M[] = $N["Engine"];
        }
        return $M;
    }

    function
    logged_user()
    {
        global $h;
        return $h->result("SELECT USER()");
    }

    function
    tables_list()
    {
        return
            get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
    }

    function
    count_tables($db)
    {
        $M = array();
        foreach ($db
                 as $j) $M[$j] = count(get_vals("SHOW TABLES IN " . idf_escape($j)));
        return $M;
    }

    function
    table_status($E = "", $Gb = false)
    {
        $M = array();
        foreach (get_rows($Gb && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($E != "" ? "AND TABLE_NAME = " . q($E) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($E != "" ? " LIKE " . q(addcslashes($E, "%_\\")) : "")) as $N) {
            if ($N["Engine"] == "InnoDB") $N["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $N["Comment"]);
            if (!isset($N["Engine"])) $N["Comment"] = "";
            if ($E != "") return $N;
            $M[$N["Name"]] = $N;
        }
        return $M;
    }

    function
    is_view($T)
    {
        return $T["Engine"] === null;
    }

    function
    fk_support($T)
    {
        return
            preg_match('~InnoDB|IBMDB2I~i', $T["Engine"]) || (preg_match('~NDB~i', $T["Engine"]) && min_version(5.6));
    }

    function
    fields($S)
    {
        $M = array();
        foreach (get_rows("SHOW FULL COLUMNS FROM " . table($S)) as $N) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $N["Type"], $B);
            $M[$N["Field"]] = array("field" => $N["Field"], "full_type" => $N["Type"], "type" => $B[1], "length" => $B[2], "unsigned" => ltrim($B[3] . $B[4]), "default" => ($N["Default"] != "" || preg_match("~char|set~", $B[1]) ? $N["Default"] : null), "null" => ($N["Null"] == "YES"), "auto_increment" => ($N["Extra"] == "auto_increment"), "on_update" => (preg_match('~^on update (.+)~i', $N["Extra"], $B) ? $B[1] : ""), "collation" => $N["Collation"], "privileges" => array_flip(preg_split('~, *~', $N["Privileges"])), "comment" => $N["Comment"], "primary" => ($N["Key"] == "PRI"),);
        }
        return $M;
    }

    function
    indexes($S, $i = null)
    {
        $M = array();
        foreach (get_rows("SHOW INDEX FROM " . table($S), $i) as $N) {
            $E = $N["Key_name"];
            $M[$E]["type"] = ($E == "PRIMARY" ? "PRIMARY" : ($N["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($N["Non_unique"] ? ($N["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
            $M[$E]["columns"][] = $N["Column_name"];
            $M[$E]["lengths"][] = ($N["Index_type"] == "SPATIAL" ? null : $N["Sub_part"]);
            $M[$E]["descs"][] = null;
        }
        return $M;
    }

    function
    foreign_keys($S)
    {
        global $h, $bd;
        static $qd = '(?:`(?:[^`]|``)+`)|(?:"(?:[^"]|"")+")';
        $M = array();
        $Wa = $h->result("SHOW CREATE TABLE " . table($S), 1);
        if ($Wa) {
            preg_match_all("~CONSTRAINT ($qd) FOREIGN KEY ?\\(((?:$qd,? ?)+)\\) REFERENCES ($qd)(?:\\.($qd))? \\(((?:$qd,? ?)+)\\)(?: ON DELETE ($bd))?(?: ON UPDATE ($bd))?~", $Wa, $Lc, PREG_SET_ORDER);
            foreach ($Lc
                     as $B) {
                preg_match_all("~$qd~", $B[2], $fe);
                preg_match_all("~$qd~", $B[5], $xe);
                $M[idf_unescape($B[1])] = array("db" => idf_unescape($B[4] != "" ? $B[3] : $B[4]), "table" => idf_unescape($B[4] != "" ? $B[4] : $B[3]), "source" => array_map('idf_unescape', $fe[0]), "target" => array_map('idf_unescape', $xe[0]), "on_delete" => ($B[6] ? $B[6] : "RESTRICT"), "on_update" => ($B[7] ? $B[7] : "RESTRICT"),);
            }
        }
        return $M;
    }

    function
    view($E)
    {
        global $h;
        return
            array("select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $h->result("SHOW CREATE VIEW " . table($E), 1)));
    }

    function
    collations()
    {
        $M = array();
        foreach (get_rows("SHOW COLLATION") as $N) {
            if ($N["Default"]) $M[$N["Charset"]][-1] = $N["Collation"]; else$M[$N["Charset"]][] = $N["Collation"];
        }
        ksort($M);
        foreach ($M
                 as $y => $W) asort($M[$y]);
        return $M;
    }

    function
    information_schema($j)
    {
        return (min_version(5) && $j == "information_schema") || (min_version(5.5) && $j == "performance_schema");
    }

    function
    error()
    {
        global $h;
        return
            h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $h->error));
    }

    function
    create_database($j, $Ma)
    {
        return
            queries("CREATE DATABASE " . idf_escape($j) . ($Ma ? " COLLATE " . q($Ma) : ""));
    }

    function
    drop_databases($db)
    {
        $M = apply_queries("DROP DATABASE", $db, 'idf_escape');
        restart_session();
        set_session("dbs", null);
        return $M;
    }

    function
    rename_database($E, $Ma)
    {
        $M = false;
        if (create_database($E, $Ma)) {
            $Jd = array();
            foreach (tables_list() as $S => $Ne) $Jd[] = table($S) . " TO " . idf_escape($E) . "." . table($S);
            $M = (!$Jd || queries("RENAME TABLE " . implode(", ", $Jd)));
            if ($M) queries("DROP DATABASE " . idf_escape(DB));
            restart_session();
            set_session("dbs", null);
        }
        return $M;
    }

    function
    auto_increment()
    {
        $ta = " PRIMARY KEY";
        if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
            foreach (indexes($_GET["create"]) as $nc) {
                if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $nc["columns"], true)) {
                    $ta = "";
                    break;
                }
                if ($nc["type"] == "PRIMARY") $ta = " UNIQUE";
            }
        }
        return " AUTO_INCREMENT$ta";
    }

    function
    alter_table($S, $E, $n, $Ob, $Qa, $wb, $Ma, $sa, $pd)
    {
        $ma = array();
        foreach ($n
                 as $m) $ma[] = ($m[1] ? ($S != "" ? ($m[0] != "" ? "CHANGE " . idf_escape($m[0]) : "ADD") : " ") . " " . implode($m[1]) . ($S != "" ? $m[2] : "") : "DROP " . idf_escape($m[0]));
        $ma = array_merge($ma, $Ob);
        $ke = ($Qa !== null ? " COMMENT=" . q($Qa) : "") . ($wb ? " ENGINE=" . q($wb) : "") . ($Ma ? " COLLATE " . q($Ma) : "") . ($sa != "" ? " AUTO_INCREMENT=$sa" : "");
        if ($S == "") return
            queries("CREATE TABLE " . table($E) . " (\n" . implode(",\n", $ma) . "\n)$ke$pd");
        if ($S != $E) $ma[] = "RENAME TO " . table($E);
        if ($ke) $ma[] = ltrim($ke);
        return ($ma || $pd ? queries("ALTER TABLE " . table($S) . "\n" . implode(",\n", $ma) . $pd) : true);
    }

    function
    alter_indexes($S, $ma)
    {
        foreach ($ma
                 as $y => $W) $ma[$y] = ($W[2] == "DROP" ? "\nDROP INDEX " . idf_escape($W[1]) : "\nADD $W[0] " . ($W[0] == "PRIMARY" ? "KEY " : "") . ($W[1] != "" ? idf_escape($W[1]) . " " : "") . "(" . implode(", ", $W[2]) . ")");
        return
            queries("ALTER TABLE " . table($S) . implode(",", $ma));
    }

    function
    truncate_tables($ve)
    {
        return
            apply_queries("TRUNCATE TABLE", $ve);
    }

    function
    drop_views($ef)
    {
        return
            queries("DROP VIEW " . implode(", ", array_map('table', $ef)));
    }

    function
    drop_tables($ve)
    {
        return
            queries("DROP TABLE " . implode(", ", array_map('table', $ve)));
    }

    function
    move_tables($ve, $ef, $xe)
    {
        $Jd = array();
        foreach (array_merge($ve, $ef) as $S) $Jd[] = table($S) . " TO " . idf_escape($xe) . "." . table($S);
        return
            queries("RENAME TABLE " . implode(", ", $Jd));
    }

    function
    copy_tables($ve, $ef, $xe)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        foreach ($ve
                 as $S) {
            $E = ($xe == DB ? table("copy_$S") : idf_escape($xe) . "." . table($S));
            if (!queries("CREATE TABLE $E LIKE " . table($S)) || !queries("INSERT INTO $E SELECT * FROM " . table($S))) return
                false;
            foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($S, "%_\\"))) as $N) {
                $Me = $N["Trigger"];
                if (!queries("CREATE TRIGGER " . ($xe == DB ? idf_escape("copy_$Me") : idf_escape($xe) . "." . idf_escape($Me)) . " $N[Timing] $N[Event] ON $E FOR EACH ROW\n$N[Statement];")) return
                    false;
            }
        }
        foreach ($ef
                 as $S) {
            $E = ($xe == DB ? table("copy_$S") : idf_escape($xe) . "." . table($S));
            $df = view($S);
            if (!queries("CREATE VIEW $E AS $df[select]")) return
                false;
        }
        return
            true;
    }

    function
    trigger($E)
    {
        if ($E == "") return
            array();
        $O = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($E));
        return
            reset($O);
    }

    function
    triggers($S)
    {
        $M = array();
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($S, "%_\\"))) as $N) $M[$N["Trigger"]] = array($N["Timing"], $N["Event"]);
        return $M;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("FOR EACH ROW"),);
    }

    function
    routine($E, $Ne)
    {
        global $h, $xb, $qc, $Pe;
        $la = array("bool", "boolean", "integer", "double precision", "real", "dec", "numeric", "fixed", "national char", "national varchar");
        $ge = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $Oe = "((" . implode("|", array_merge(array_keys($Pe), $la)) . ")\\b(?:\\s*\\(((?:[^'\")]|$xb)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $qd = "$ge*(" . ($Ne == "FUNCTION" ? "" : $qc) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Oe";
        $Va = $h->result("SHOW CREATE $Ne " . idf_escape($E), 2);
        preg_match("~\\(((?:$qd\\s*,?)*)\\)\\s*" . ($Ne == "FUNCTION" ? "RETURNS\\s+$Oe\\s+" : "") . "(.*)~is", $Va, $B);
        $n = array();
        preg_match_all("~$qd\\s*,?~is", $B[1], $Lc, PREG_SET_ORDER);
        foreach ($Lc
                 as $nd) {
            $E = str_replace("``", "`", $nd[2]) . $nd[3];
            $n[] = array("field" => $E, "type" => strtolower($nd[5]), "length" => preg_replace_callback("~$xb~s", 'normalize_enum', $nd[6]), "unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$nd[8] $nd[7]"))), "null" => 1, "full_type" => $nd[4], "inout" => strtoupper($nd[1]), "collation" => strtolower($nd[9]),);
        }
        if ($Ne != "FUNCTION") return
            array("fields" => $n, "definition" => $B[11]);
        return
            array("fields" => $n, "returns" => array("type" => $B[12], "length" => $B[13], "unsigned" => $B[15], "collation" => $B[16]), "definition" => $B[17], "language" => "SQL",);
    }

    function
    routines()
    {
        return
            get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
    }

    function
    routine_languages()
    {
        return
            array();
    }

    function
    routine_id($E, $N)
    {
        return
            idf_escape($E);
    }

    function
    last_id()
    {
        global $h;
        return $h->result("SELECT LAST_INSERT_ID()");
    }

    function
    explain($h, $K)
    {
        return $h->query("EXPLAIN " . (min_version(5.1) ? "PARTITIONS " : "") . $K);
    }

    function
    found_rows($T, $Z)
    {
        return ($Z || $T["Engine"] != "InnoDB" ? null : $T["Rows"]);
    }

    function
    types()
    {
        return
            array();
    }

    function
    schemas()
    {
        return
            array();
    }

    function
    get_schema()
    {
        return "";
    }

    function
    set_schema($Qd)
    {
        return
            true;
    }

    function
    create_sql($S, $sa, $oe)
    {
        global $h;
        $M = $h->result("SHOW CREATE TABLE " . table($S), 1);
        if (!$sa) $M = preg_replace('~ AUTO_INCREMENT=\d+~', '', $M);
        return $M;
    }

    function
    truncate_sql($S)
    {
        return "TRUNCATE " . table($S);
    }

    function
    use_sql($cb)
    {
        return "USE " . idf_escape($cb);
    }

    function
    trigger_sql($S)
    {
        $M = "";
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($S, "%_\\")), null, "-- ") as $N) $M .= "\nCREATE TRIGGER " . idf_escape($N["Trigger"]) . " $N[Timing] $N[Event] ON " . table($N["Table"]) . " FOR EACH ROW\n$N[Statement];;\n";
        return $M;
    }

    function
    show_variables()
    {
        return
            get_key_vals("SHOW VARIABLES");
    }

    function
    process_list()
    {
        return
            get_rows("SHOW FULL PROCESSLIST");
    }

    function
    show_status()
    {
        return
            get_key_vals("SHOW STATUS");
    }

    function
    convert_field($m)
    {
        if (preg_match("~binary~", $m["type"])) return "HEX(" . idf_escape($m["field"]) . ")";
        if ($m["type"] == "bit") return "BIN(" . idf_escape($m["field"]) . " + 0)";
        if (preg_match("~geometry|point|linestring|polygon~", $m["type"])) return (min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($m["field"]) . ")";
    }

    function
    unconvert_field($m, $M)
    {
        if (preg_match("~binary~", $m["type"])) $M = "UNHEX($M)";
        if ($m["type"] == "bit") $M = "CONV($M, 2, 10) + 0";
        if (preg_match("~geometry|point|linestring|polygon~", $m["type"])) $M = (min_version(8) ? "ST_" : "") . "GeomFromText($M)";
        return $M;
    }

    function
    support($Hb)
    {
        return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $Hb);
    }

    function
    kill_process($W)
    {
        return
            queries("KILL " . number($W));
    }

    function
    connection_id()
    {
        return "SELECT CONNECTION_ID()";
    }

    function
    max_connections()
    {
        global $h;
        return $h->result("SELECT @@max_connections");
    }

    $x = "sql";
    $Pe = array();
    $ne = array();
    foreach (array(lang(24) => array("tinyint" => 3, "smallint" => 5, "mediumint" => 8, "int" => 10, "bigint" => 20, "decimal" => 66, "float" => 12, "double" => 21), lang(25) => array("date" => 10, "datetime" => 19, "timestamp" => 19, "time" => 10, "year" => 4), lang(23) => array("char" => 255, "varchar" => 65535, "tinytext" => 255, "text" => 65535, "mediumtext" => 16777215, "longtext" => 4294967295), lang(26) => array("enum" => 65535, "set" => 64), lang(27) => array("bit" => 20, "binary" => 255, "varbinary" => 65535, "tinyblob" => 255, "blob" => 65535, "mediumblob" => 16777215, "longblob" => 4294967295), lang(28) => array("geometry" => 0, "point" => 0, "linestring" => 0, "polygon" => 0, "multipoint" => 0, "multilinestring" => 0, "multipolygon" => 0, "geometrycollection" => 0),) as $y => $W) {
        $Pe += $W;
        $ne[$y] = array_keys($W);
    }
    $We = array("unsigned", "zerofill", "unsigned zerofill");
    $gd = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "REGEXP", "IN", "FIND_IN_SET", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL");
    $Wb = array("char_length", "date", "from_unixtime", "lower", "round", "floor", "ceil", "sec_to_time", "time_to_sec", "upper");
    $Zb = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum");
    $pb = array(array("char" => "md5/sha1/password/encrypt/uuid", "binary" => "md5/sha1", "date|time" => "now",), array(number_type() => "+/-", "date" => "+ interval/- interval", "time" => "addtime/subtime", "char|text" => "concat",));
}
define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", preg_replace('~^[^?]*/([^?]*).*~', '\1', $_SERVER["REQUEST_URI"]) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$ba = "4.7.1";

class
Adminer
{
    var $operators = array("<=", ">=");
    var $_values = array();

    function
    name()
    {
        return "<a href='https://www.adminer.org/editor/'" . target_blank() . " id='h1'>" . lang(29) . "</a>";
    }

    function
    credentials()
    {
        return
            array(SERVER, $_GET["username"], get_password());
    }

    function
    connectSsl()
    {
    }

    function
    permanentLogin($Va = false)
    {
        return
            password_file($Va);
    }

    function
    bruteForceKey()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    function
    serverName($Q)
    {
    }

    function
    database()
    {
        global $h;
        if ($h) {
            $db = $this->databases(false);
            return (!$db ? $h->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1)") : $db[(information_schema($db[0]) ? 1 : 0)]);
        }
    }

    function
    schemas()
    {
        return
            schemas();
    }

    function
    databases($Mb = true)
    {
        return
            get_databases($Mb);
    }

    function
    queryTimeout()
    {
        return
            5;
    }

    function
    headers()
    {
    }

    function
    csp()
    {
        return
            csp();
    }

    function
    head()
    {
        return
            true;
    }

    function
    css()
    {
        $M = array();
        $o = "adminer.css";
        if (file_exists($o)) $M[] = $o;
        return $M;
    }

    function
    loginForm()
    {
        echo "<table cellspacing='0' class='layout'>\n", $this->loginFormField('username', '<tr><th>' . lang(30) . '<td>', '<input type="hidden" name="auth[driver]" value="server"><input name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username'));")), $this->loginFormField('password', '<tr><th>' . lang(31) . '<td>', '<input type="password" name="auth[password]" autocomplete="current-password">' . "\n"), "</table>\n", "<p><input type='submit' value='" . lang(32) . "'>\n", checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang(33)) . "\n";
    }

    function
    loginFormField($E, $gc, $X)
    {
        return $gc . $X;
    }

    function
    login($Hc, $J)
    {
        return
            true;
    }

    function
    tableName($te)
    {
        return
            h($te["Comment"] != "" ? $te["Comment"] : $te["Name"]);
    }

    function
    fieldName($m, $H = 0)
    {
        return
            h(preg_replace('~\s+\[.*\]$~', '', ($m["comment"] != "" ? $m["comment"] : $m["field"])));
    }

    function
    selectLinks($te, $R = "")
    {
        $b = $te["Name"];
        if ($R !== null) echo '<p class="tabs"><a href="' . h(ME . 'edit=' . urlencode($b) . $R) . '">' . lang(34) . "</a>\n";
    }

    function
    foreignKeys($S)
    {
        return
            foreign_keys($S);
    }

    function
    backwardKeys($S, $se)
    {
        $M = array();
        foreach (get_rows("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = " . q($this->database()) . "
AND REFERENCED_TABLE_SCHEMA = " . q($this->database()) . "
AND REFERENCED_TABLE_NAME = " . q($S) . "
ORDER BY ORDINAL_POSITION", null, "") as $N) $M[$N["TABLE_NAME"]]["keys"][$N["CONSTRAINT_NAME"]][$N["COLUMN_NAME"]] = $N["REFERENCED_COLUMN_NAME"];
        foreach ($M
                 as $y => $W) {
            $E = $this->tableName(table_status($y, true));
            if ($E != "") {
                $Rd = preg_quote($se);
                $Xd = "(:|\\s*-)?\\s+";
                $M[$y]["name"] = (preg_match("(^$Rd$Xd(.+)|^(.+?)$Xd$Rd\$)iu", $E, $B) ? $B[2] . $B[3] : $E);
            } else
                unset($M[$y]);
        }
        return $M;
    }

    function
    backwardKeysPrint($wa, $N)
    {
        foreach ($wa
                 as $S => $va) {
            foreach ($va["keys"] as $Oa) {
                $_ = ME . 'select=' . urlencode($S);
                $s = 0;
                foreach ($Oa
                         as $e => $W) $_ .= where_link($s++, $e, $N[$W]);
                echo "<a href='" . h($_) . "'>" . h($va["name"]) . "</a>";
                $_ = ME . 'edit=' . urlencode($S);
                foreach ($Oa
                         as $e => $W) $_ .= "&set" . urlencode("[" . bracket_escape($e) . "]") . "=" . urlencode($N[$W]);
                echo "<a href='" . h($_) . "' title='" . lang(34) . "'>+</a> ";
            }
        }
    }

    function
    selectQuery($K, $je, $Fb = false)
    {
        return "<!--\n" . str_replace("--", "--><!-- ", $K) . "\n(" . format_time($je) . ")\n-->\n";
    }

    function
    rowDescription($S)
    {
        foreach (fields($S) as $m) {
            if (preg_match("~varchar|character varying~", $m["type"])) return
                idf_escape($m["field"]);
        }
        return "";
    }

    function
    rowDescriptions($O, $Qb)
    {
        $M = $O;
        foreach ($O[0] as $y => $W) {
            if (list($S, $t, $E) = $this->_foreignColumn($Qb, $y)) {
                $lc = array();
                foreach ($O
                         as $N) $lc[$N[$y]] = q($N[$y]);
                $hb = $this->_values[$S];
                if (!$hb) $hb = get_key_vals("SELECT $t, $E FROM " . table($S) . " WHERE $t IN (" . implode(", ", $lc) . ")");
                foreach ($O
                         as $D => $N) {
                    if (isset($N[$y])) $M[$D][$y] = (string)$hb[$N[$y]];
                }
            }
        }
        return $M;
    }

    function
    selectLink($W, $m)
    {
    }

    function
    selectVal($W, $_, $m, $jd)
    {
        $M = $W;
        $_ = h($_);
        if (preg_match('~blob|bytea~', $m["type"]) && !is_utf8($W)) {
            $M = lang(35, strlen($jd));
            if (preg_match("~^(GIF|\xFF\xD8\xFF|\x89PNG\x0D\x0A\x1A\x0A)~", $jd)) $M = "<img src='$_' alt='$M'>";
        }
        if (like_bool($m) && $M != "") $M = (preg_match('~^(1|t|true|y|yes|on)$~i', $W) ? lang(36) : lang(37));
        if ($_) $M = "<a href='$_'" . (is_url($_) ? target_blank() : "") . ">$M</a>";
        if (!$_ && !like_bool($m) && preg_match(number_type(), $m["type"])) $M = "<div class='number'>$M</div>"; elseif (preg_match('~date~', $m["type"])) $M = "<div class='datetime'>$M</div>";
        return $M;
    }

    function
    editVal($W, $m)
    {
        if (preg_match('~date|timestamp~', $m["type"]) && $W !== null) return
            preg_replace('~^(\d{2}(\d+))-(0?(\d+))-(0?(\d+))~', lang(38), $W);
        return $W;
    }

    function
    selectColumnsPrint($P, $f)
    {
    }

    function
    selectSearchPrint($Z, $f, $v)
    {
        $Z = (array)$_GET["where"];
        echo '<fieldset id="fieldset-search"><legend>' . lang(39) . "</legend><div>\n";
        $wc = array();
        foreach ($Z
                 as $y => $W) $wc[$W["col"]] = $y;
        $s = 0;
        $n = fields($_GET["select"]);
        foreach ($f
                 as $E => $gb) {
            $m = $n[$E];
            if (preg_match("~enum~", $m["type"]) || like_bool($m)) {
                $y = $wc[$E];
                $s--;
                echo "<div>" . h($gb) . "<input type='hidden' name='where[$s][col]' value='" . h($E) . "'>:", (like_bool($m) ? " <select name='where[$s][val]'>" . optionlist(array("" => "", lang(37), lang(36)), $Z[$y]["val"], true) . "</select>" : enum_input("checkbox", " name='where[$s][val][]'", $m, (array)$Z[$y]["val"], ($m["null"] ? 0 : null))), "</div>\n";
                unset($f[$E]);
            } elseif (is_array($G = $this->_foreignKeyOptions($_GET["select"], $E))) {
                if ($n[$E]["null"]) $G[0] = '(' . lang(7) . ')';
                $y = $wc[$E];
                $s--;
                echo "<div>" . h($gb) . "<input type='hidden' name='where[$s][col]' value='" . h($E) . "'><input type='hidden' name='where[$s][op]' value='='>: <select name='where[$s][val]'>" . optionlist($G, $Z[$y]["val"], true) . "</select></div>\n";
                unset($f[$E]);
            }
        }
        $s = 0;
        foreach ($Z
                 as $W) {
            if (($W["col"] == "" || $f[$W["col"]]) && "$W[col]$W[val]" != "") {
                echo "<div><select name='where[$s][col]'><option value=''>(" . lang(40) . ")" . optionlist($f, $W["col"], true) . "</select>", html_select("where[$s][op]", array(-1 => "") + $this->operators, $W["op"]), "<input type='search' name='where[$s][val]' value='" . h($W["val"]) . "'>" . script("mixin(qsl('input'), {onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", "") . "</div>\n";
                $s++;
            }
        }
        echo "<div><select name='where[$s][col]'><option value=''>(" . lang(40) . ")" . optionlist($f, null, true) . "</select>", script("qsl('select').onchange = selectAddRow;", ""), html_select("where[$s][op]", array(-1 => "") + $this->operators), "<input type='search' name='where[$s][val]'></div>", script("mixin(qsl('input'), {onchange: function () { this.parentNode.firstChild.onchange(); }, onsearch: selectSearchSearch});"), "</div></fieldset>\n";
    }

    function
    selectOrderPrint($H, $f, $v)
    {
        $id = array();
        foreach ($v
                 as $y => $nc) {
            $H = array();
            foreach ($nc["columns"] as $W) $H[] = $f[$W];
            if (count(array_filter($H, 'strlen')) > 1 && $y != "PRIMARY") $id[$y] = implode(", ", $H);
        }
        if ($id) {
            echo '<fieldset><legend>' . lang(41) . "</legend><div>", "<select name='index_order'>" . optionlist(array("" => "") + $id, ($_GET["order"][0] != "" ? "" : $_GET["index_order"]), true) . "</select>", "</div></fieldset>\n";
        }
        if ($_GET["order"]) echo "<div style='display: none;'>" . hidden_fields(array("order" => array(1 => reset($_GET["order"])), "desc" => ($_GET["desc"] ? array(1 => 1) : array()),)) . "</div>\n";
    }

    function
    selectLimitPrint($z)
    {
        echo "<fieldset><legend>" . lang(42) . "</legend><div>";
        echo
        html_select("limit", array("", "50", "100"), $z), "</div></fieldset>\n";
    }

    function
    selectLengthPrint($ze)
    {
    }

    function
    selectActionPrint($v)
    {
        echo "<fieldset><legend>" . lang(43) . "</legend><div>", "<input type='submit' value='" . lang(44) . "'>", "</div></fieldset>\n";
    }

    function
    selectCommandPrint()
    {
        return
            true;
    }

    function
    selectImportPrint()
    {
        return
            true;
    }

    function
    selectEmailPrint($tb, $f)
    {
        if ($tb) {
            print_fieldset("email", lang(45), $_POST["email_append"]);
            echo "<div>", script("qsl('div').onkeydown = partialArg(bodyKeydown, 'email');"), "<p>" . lang(46) . ": <input name='email_from' value='" . h($_POST ? $_POST["email_from"] : $_COOKIE["adminer_email"]) . "'>\n", lang(47) . ": <input name='email_subject' value='" . h($_POST["email_subject"]) . "'>\n", "<p><textarea name='email_message' rows='15' cols='75'>" . h($_POST["email_message"] . ($_POST["email_append"] ? '{$' . "$_POST[email_addition]}" : "")) . "</textarea>\n", "<p>" . script("qsl('p').onkeydown = partialArg(bodyKeydown, 'email_append');", "") . html_select("email_addition", $f, $_POST["email_addition"]) . "<input type='submit' name='email_append' value='" . lang(11) . "'>\n";
            echo "<p>" . lang(48) . ": <input type='file' name='email_files[]'>" . script("qsl('input').onchange = emailFileChange;"), "<p>" . (count($tb) == 1 ? '<input type="hidden" name="email_field" value="' . h(key($tb)) . '">' : html_select("email_field", $tb)), "<input type='submit' name='email' value='" . lang(49) . "'>" . confirm(), "</div>\n", "</div></fieldset>\n";
        }
    }

    function
    selectColumnsProcess($f, $v)
    {
        return
            array(array(), array());
    }

    function
    selectSearchProcess($n, $v)
    {
        $M = array();
        foreach ((array)$_GET["where"] as $y => $Z) {
            $La = $Z["col"];
            $ed = $Z["op"];
            $W = $Z["val"];
            if (($y < 0 ? "" : $La) . $W != "") {
                $Ra = array();
                foreach (($La != "" ? array($La => $n[$La]) : $n) as $E => $m) {
                    if ($La != "" || is_numeric($W) || !preg_match(number_type(), $m["type"])) {
                        $E = idf_escape($E);
                        if ($La != "" && $m["type"] == "enum") $Ra[] = (in_array(0, $W) ? "$E IS NULL OR " : "") . "$E IN (" . implode(", ", array_map('intval', $W)) . ")"; else {
                            $_e = preg_match('~char|text|enum|set~', $m["type"]);
                            $X = $this->processInput($m, (!$ed && $_e && preg_match('~^[^%]+$~', $W) ? "%$W%" : $W));
                            $Ra[] = $E . ($X == "NULL" ? " IS" . ($ed == ">=" ? " NOT" : "") . " $X" : (in_array($ed, $this->operators) || $ed == "=" ? " $ed $X" : ($_e ? " LIKE $X" : " IN (" . str_replace(",", "', '", $X) . ")")));
                            if ($y < 0 && $W == "0") $Ra[] = "$E IS NULL";
                        }
                    }
                }
                $M[] = ($Ra ? "(" . implode(" OR ", $Ra) . ")" : "1 = 0");
            }
        }
        return $M;
    }

    function
    selectOrderProcess($n, $v)
    {
        $oc = $_GET["index_order"];
        if ($oc != "") unset($_GET["order"][1]);
        if ($_GET["order"]) return
            array(idf_escape(reset($_GET["order"])) . ($_GET["desc"] ? " DESC" : ""));
        foreach (($oc != "" ? array($v[$oc]) : $v) as $nc) {
            if ($oc != "" || $nc["type"] == "INDEX") {
                $bc = array_filter($nc["descs"]);
                $gb = false;
                foreach ($nc["columns"] as $W) {
                    if (preg_match('~date|timestamp~', $n[$W]["type"])) {
                        $gb = true;
                        break;
                    }
                }
                $M = array();
                foreach ($nc["columns"] as $y => $W) $M[] = idf_escape($W) . (($bc ? $nc["descs"][$y] : $gb) ? " DESC" : "");
                return $M;
            }
        }
        return
            array();
    }

    function
    selectLimitProcess()
    {
        return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
    }

    function
    selectLengthProcess()
    {
        return "100";
    }

    function
    selectEmailProcess($Z, $Qb)
    {
        if ($_POST["email_append"]) return
            true;
        if ($_POST["email"]) {
            $Vd = 0;
            if ($_POST["all"] || $_POST["check"]) {
                $m = idf_escape($_POST["email_field"]);
                $pe = $_POST["email_subject"];
                $C = $_POST["email_message"];
                preg_match_all('~\{\$([a-z0-9_]+)\}~i', "$pe.$C", $Lc);
                $O = get_rows("SELECT DISTINCT $m" . ($Lc[1] ? ", " . implode(", ", array_map('idf_escape', array_unique($Lc[1]))) : "") . " FROM " . table($_GET["select"]) . " WHERE $m IS NOT NULL AND $m != ''" . ($Z ? " AND " . implode(" AND ", $Z) : "") . ($_POST["all"] ? "" : " AND ((" . implode(") OR (", array_map('where_check', (array)$_POST["check"])) . "))"));
                $n = fields($_GET["select"]);
                foreach ($this->rowDescriptions($O, $Qb) as $N) {
                    $Kd = array('{\\' => '{');
                    foreach ($Lc[1] as $W) $Kd['{$' . "$W}"] = $this->editVal($N[$W], $n[$W]);
                    $sb = $N[$_POST["email_field"]];
                    if (is_mail($sb) && send_mail($sb, strtr($pe, $Kd), strtr($C, $Kd), $_POST["email_from"], $_FILES["email_files"])) $Vd++;
                }
            }
            cookie("adminer_email", $_POST["email_from"]);
            redirect(remove_from_uri(), lang(50, $Vd));
        }
        return
            false;
    }

    function
    selectQueryBuild($P, $Z, $r, $H, $z, $I)
    {
        return "";
    }

    function
    messageQuery($K, $Ae, $Fb = false)
    {
        return " <span class='time'>" . @date("H:i:s") . "</span><!--\n" . str_replace("--", "--><!-- ", $K) . "\n" . ($Ae ? "($Ae)\n" : "") . "-->";
    }

    function
    editFunctions($m)
    {
        $M = array();
        if ($m["null"] && preg_match('~blob~', $m["type"])) $M["NULL"] = lang(7);
        $M[""] = ($m["null"] || $m["auto_increment"] || like_bool($m) ? "" : "*");
        if (preg_match('~date|time~', $m["type"])) $M["now"] = lang(51);
        if (preg_match('~_(md5|sha1)$~i', $m["field"], $B)) $M[] = strtolower($B[1]);
        return $M;
    }

    function
    editInput($S, $m, $d, $X)
    {
        if ($m["type"] == "enum") return (isset($_GET["select"]) ? "<label><input type='radio'$d value='-1' checked><i>" . lang(8) . "</i></label> " : "") . enum_input("radio", $d, $m, ($X || isset($_GET["select"]) ? $X : 0), ($m["null"] ? "" : null));
        $G = $this->_foreignKeyOptions($S, $m["field"], $X);
        if ($G !== null) return (is_array($G) ? "<select$d>" . optionlist($G, $X, true) . "</select>" : "<input value='" . h($X) . "'$d class='hidden'>" . "<input value='" . h($G) . "' class='jsonly'>" . "<div></div>" . script("qsl('input').oninput = partial(whisper, '" . ME . "script=complete&source=" . urlencode($S) . "&field=" . urlencode($m["field"]) . "&value=');
qsl('div').onclick = whisperClick;", ""));
        if (like_bool($m)) return '<input type="checkbox" value="1"' . (preg_match('~^(1|t|true|y|yes|on)$~i', $X) ? ' checked' : '') . "$d>";
        $hc = "";
        if (preg_match('~time~', $m["type"])) $hc = lang(52);
        if (preg_match('~date|timestamp~', $m["type"])) $hc = lang(53) . ($hc ? " [$hc]" : "");
        if ($hc) return "<input value='" . h($X) . "'$d> ($hc)";
        if (preg_match('~_(md5|sha1)$~i', $m["field"])) return "<input type='password' value='" . h($X) . "'$d>";
        return '';
    }

    function
    editHint($S, $m, $X)
    {
        return (preg_match('~\s+(\[.*\])$~', ($m["comment"] != "" ? $m["comment"] : $m["field"]), $B) ? h(" $B[1]") : '');
    }

    function
    processInput($m, $X, $q = "")
    {
        if ($q == "now") return "$q()";
        $M = $X;
        if (preg_match('~date|timestamp~', $m["type"]) && preg_match('(^' . str_replace('\$1', '(?P<p1>\d*)', preg_replace('~(\\\\\\$([2-6]))~', '(?P<p\2>\d{1,2})', preg_quote(lang(38)))) . '(.*))', $X, $B)) $M = ($B["p1"] != "" ? $B["p1"] : ($B["p2"] != "" ? ($B["p2"] < 70 ? 20 : 19) . $B["p2"] : gmdate("Y"))) . "-$B[p3]$B[p4]-$B[p5]$B[p6]" . end($B);
        $M = ($m["type"] == "bit" && preg_match('~^[0-9]+$~', $X) ? $M : q($M));
        if ($X == "" && like_bool($m)) $M = "'0'"; elseif ($X == "" && ($m["null"] || !preg_match('~char|text~', $m["type"]))) $M = "NULL";
        elseif (preg_match('~^(md5|sha1)$~', $q)) $M = "$q($M)";
        return
            unconvert_field($m, $M);
    }

    function
    dumpOutput()
    {
        return
            array();
    }

    function
    dumpFormat()
    {
        return
            array('csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV');
    }

    function
    dumpDatabase($j)
    {
    }

    function
    dumpTable()
    {
        echo "\xef\xbb\xbf";
    }

    function
    dumpData($S, $oe, $K)
    {
        global $h;
        $L = $h->query($K, 1);
        if ($L) {
            while ($N = $L->fetch_assoc()) {
                if ($oe == "table") {
                    dump_csv(array_keys($N));
                    $oe = "INSERT";
                }
                dump_csv($N);
            }
        }
    }

    function
    dumpFilename($kc)
    {
        return
            friendly_url($kc);
    }

    function
    dumpHeaders($kc, $Tc = false)
    {
        $Db = "csv";
        header("Content-Type: text/csv; charset=utf-8");
        return $Db;
    }

    function
    importServerPath()
    {
    }

    function
    homepage()
    {
        return
            true;
    }

    function
    navigation($Sc)
    {
        global $ba;
        echo '<h1>
', $this->name(), ' <span class="version">', $ba, '</span>
<a href="https://www.adminer.org/editor/#download"', target_blank(), ' id="version">', (version_compare($ba, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""), '</a>
</h1>
';
        if ($Sc == "auth") {
            $Lb = true;
            foreach ((array)$_SESSION["pwds"] as $Y => $Zd) {
                foreach ($Zd[""] as $U => $J) {
                    if ($J !== null) {
                        if ($Lb) {
                            echo "<ul id='logins'>", script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
                            $Lb = false;
                        }
                        echo "<li><a href='" . h(auth_url($Y, "", $U)) . "'>" . ($U != "" ? h($U) : "<i>" . lang(7) . "</i>") . "</a>\n";
                    }
                }
            }
        } else {
            $this->databasesPrint($Sc);
            if ($Sc != "db" && $Sc != "ns") {
                $T = table_status('', true);
                if (!$T) echo "<p class='message'>" . lang(9) . "\n"; else$this->tablesPrint($T);
            }
        }
    }

    function
    databasesPrint($Sc)
    {
    }

    function
    tablesPrint($ve)
    {
        echo "<ul id='tables'>", script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
        foreach ($ve
                 as $N) {
            echo '<li>';
            $E = $this->tableName($N);
            if (isset($N["Engine"]) && $E != "") echo "<a href='" . h(ME) . 'select=' . urlencode($N["Name"]) . "'" . bold($_GET["select"] == $N["Name"] || $_GET["edit"] == $N["Name"], "select") . " title='" . lang(54) . "'>$E</a>\n";
        }
        echo "</ul>\n";
    }

    function
    _foreignColumn($Qb, $e)
    {
        foreach ((array)$Qb[$e] as $Pb) {
            if (count($Pb["source"]) == 1) {
                $E = $this->rowDescription($Pb["table"]);
                if ($E != "") {
                    $t = idf_escape($Pb["target"][0]);
                    return
                        array($Pb["table"], $t, $E);
                }
            }
        }
    }

    function
    _foreignKeyOptions($S, $e, $X = null)
    {
        global $h;
        if (list($xe, $t, $E) = $this->_foreignColumn(column_foreign_keys($S), $e)) {
            $M =& $this->_values[$xe];
            if ($M === null) {
                $T = table_status($xe);
                $M = ($T["Rows"] > 1000 ? "" : array("" => "") + get_key_vals("SELECT $t, $E FROM " . table($xe) . " ORDER BY 2"));
            }
            if (!$M && $X !== null) return $h->result("SELECT $E FROM " . table($xe) . " WHERE $t = " . q($X));
            return $M;
        }
    }
}

$c = (function_exists('adminer_object') ? adminer_object() : new
Adminer);
function
page_header($Ce, $l = "", $Ca = array(), $De = "")
{
    global $a, $ba, $c, $mb, $x;
    page_headers();
    if (is_ajax() && $l) {
        page_messages($l);
        exit;
    }
    $Ee = $Ce . ($De != "" ? ": $De" : "");
    $Fe = strip_tags($Ee . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $c->name());
    echo '<!DOCTYPE html>
<html lang="', $a, '" dir="', lang(55), '">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>', $Fe, '</title>
<link rel="stylesheet" type="text/css" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.7.1"), '">
', script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.7.1");
    if ($c->head()) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.7.1"), '">
<link rel="apple-touch-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.7.1"), '">
';
        foreach ($c->css() as $Za) {
            echo '<link rel="stylesheet" type="text/css" href="', h($Za), '">
';
        }
    }
    echo '
<body class="', lang(55), ' nojs">
';
    $o = get_temp_dir() . "/adminer.version";
    if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($o) && filemtime($o) + 86400 > time()) {
        $cf = unserialize(file_get_contents($o));
        $Ad = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
        if (openssl_verify($cf["version"], base64_decode($cf["signature"]), $Ad) == 1) $_COOKIE["adminer_version"] = $cf["version"];
    }
    echo '<script', nonce(), '>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick', (isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$ba', '" . js_escape(ME) . "', '" . get_token() . "')"); ?>});
    document.body.className = document.body.className.replace(/ nojs/, ' js');
    var offlineMessage = '<?php echo
js_escape(lang(56)), '\';
var thousandsSeparator = \'', js_escape(lang(5)), '\';
</script>

<div id="help" class="jush-', $x, ' jsonly hidden"></div>
', script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"), '
<div id="content">
';
    if ($Ca !== null) {
        $_ = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
        echo '<p id="breadcrumb"><a href="' . h($_ ? $_ : ".") . '">' . $mb[DRIVER] . '</a> &raquo; ';
        $_ = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
        $Q = $c->serverName(SERVER);
        $Q = ($Q != "" ? $Q : lang(57));
        if ($Ca === false) echo "$Q\n"; else {
            echo "<a href='" . ($_ ? h($_) : ".") . "' accesskey='1' title='Alt+Shift+1'>$Q</a> &raquo; ";
            if ($_GET["ns"] != "" || (DB != "" && is_array($Ca))) echo '<a href="' . h($_ . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
            if (is_array($Ca)) {
                if ($_GET["ns"] != "") echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
                foreach ($Ca
                         as $y => $W) {
                    $gb = (is_array($W) ? $W[1] : h($W));
                    if ($gb != "") echo "<a href='" . h(ME . "$y=") . urlencode(is_array($W) ? $W[0] : $W) . "'>$gb</a> &raquo; ";
                }
            }
            echo "$Ce\n";
        }
    }
    echo "<h2>$Ee</h2>\n", "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
    restart_session();
    page_messages($l);
    $db =& get_session("dbs");
    if (DB != "" && $db && !in_array(DB, $db, true)) $db = null;
    stop_session();
    define("PAGE_HEADER", 1);
}

function
page_headers()
{
    global $c;
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache");
    header("X-Frame-Options: deny");
    header("X-XSS-Protection: 0");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: origin-when-cross-origin");
    foreach ($c->csp() as $Ya) {
        $ec = array();
        foreach ($Ya
                 as $y => $W) $ec[] = "$y $W";
        header("Content-Security-Policy: " . implode("; ", $ec));
    }
    $c->headers();
}

function
csp()
{
    return
        array(array("script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'", "connect-src" => "'self'", "frame-src" => "https://www.adminer.org", "object-src" => "'none'", "base-uri" => "'none'", "form-action" => "'self'",),);
}

function
get_nonce()
{
    static $Xc;
    if (!$Xc) $Xc = base64_encode(rand_string());
    return $Xc;
}

function
page_messages($l)
{
    $Ye = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
    $Rc = $_SESSION["messages"][$Ye];
    if ($Rc) {
        echo "<div class='message'>" . implode("</div>\n<div class='message'>", $Rc) . "</div>" . script("messagesPrint();");
        unset($_SESSION["messages"][$Ye]);
    }
    if ($l) echo "<div class='error'>$l</div>\n";
}

function
page_footer($Sc = "")
{
    global $c, $He;
    echo '</div>

';
    switch_lang();
    if ($Sc != "auth") {
        echo '<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="', lang(58), '" id="logout">
<input type="hidden" name="token" value="', $He, '">
</p>
</form>
';
    }
    echo '<div id="menu">
';
    $c->navigation($Sc);
    echo '</div>
', script("setupSubmitHighlight(document);");
}

function
int32($D)
{
    while ($D >= 2147483648) $D -= 4294967296;
    while ($D <= -2147483649) $D += 4294967296;
    return (int)$D;
}

function
long2str($V, $gf)
{
    $Pd = '';
    foreach ($V
             as $W) $Pd .= pack('V', $W);
    if ($gf) return
        substr($Pd, 0, end($V));
    return $Pd;
}

function
str2long($Pd, $gf)
{
    $V = array_values(unpack('V*', str_pad($Pd, 4 * ceil(strlen($Pd) / 4), "\0")));
    if ($gf) $V[] = strlen($Pd);
    return $V;
}

function
xxtea_mx($lf, $kf, $re, $vc)
{
    return
        int32((($lf >> 5 & 0x7FFFFFF) ^ $kf << 2) + (($kf >> 3 & 0x1FFFFFFF) ^ $lf << 4)) ^ int32(($re ^ $kf) + ($vc ^ $lf));
}

function
encrypt_string($le, $y)
{
    if ($le == "") return "";
    $y = array_values(unpack("V*", pack("H*", md5($y))));
    $V = str2long($le, true);
    $D = count($V) - 1;
    $lf = $V[$D];
    $kf = $V[0];
    $Bd = floor(6 + 52 / ($D + 1));
    $re = 0;
    while ($Bd-- > 0) {
        $re = int32($re + 0x9E3779B9);
        $ob = $re >> 2 & 3;
        for ($ld = 0; $ld < $D; $ld++) {
            $kf = $V[$ld + 1];
            $Uc = xxtea_mx($lf, $kf, $re, $y[$ld & 3 ^ $ob]);
            $lf = int32($V[$ld] + $Uc);
            $V[$ld] = $lf;
        }
        $kf = $V[0];
        $Uc = xxtea_mx($lf, $kf, $re, $y[$ld & 3 ^ $ob]);
        $lf = int32($V[$D] + $Uc);
        $V[$D] = $lf;
    }
    return
        long2str($V, false);
}

function
decrypt_string($le, $y)
{
    if ($le == "") return "";
    if (!$y) return
        false;
    $y = array_values(unpack("V*", pack("H*", md5($y))));
    $V = str2long($le, false);
    $D = count($V) - 1;
    $lf = $V[$D];
    $kf = $V[0];
    $Bd = floor(6 + 52 / ($D + 1));
    $re = int32($Bd * 0x9E3779B9);
    while ($re) {
        $ob = $re >> 2 & 3;
        for ($ld = $D; $ld > 0; $ld--) {
            $lf = $V[$ld - 1];
            $Uc = xxtea_mx($lf, $kf, $re, $y[$ld & 3 ^ $ob]);
            $kf = int32($V[$ld] - $Uc);
            $V[$ld] = $kf;
        }
        $lf = $V[$D];
        $Uc = xxtea_mx($lf, $kf, $re, $y[$ld & 3 ^ $ob]);
        $kf = int32($V[0] - $Uc);
        $V[0] = $kf;
        $re = int32($re - 0x9E3779B9);
    }
    return
        long2str($V, true);
}

$h = '';
$dc = $_SESSION["token"];
if (!$dc) $_SESSION["token"] = rand(1, 1e6);
$He = get_token();
$rd = array();
if ($_COOKIE["adminer_permanent"]) {
    foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $W) {
        list($y) = explode(":", $W);
        $rd[$y] = $W;
    }
}
function
add_invalid_login()
{
    global $c;
    $p = file_open_lock(get_temp_dir() . "/adminer.invalid");
    if (!$p) return;
    $tc = unserialize(stream_get_contents($p));
    $Ae = time();
    if ($tc) {
        foreach ($tc
                 as $uc => $W) {
            if ($W[0] < $Ae) unset($tc[$uc]);
        }
    }
    $sc =& $tc[$c->bruteForceKey()];
    if (!$sc) $sc = array($Ae + 30 * 60, 0);
    $sc[1]++;
    file_write_unlock($p, serialize($tc));
}

function
check_invalid_login()
{
    global $c;
    $tc = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
    $sc = $tc[$c->bruteForceKey()];
    $Wc = ($sc[1] > 29 ? $sc[0] - time() : 0);
    if ($Wc > 0) auth_error(lang(59, ceil($Wc / 60)));
}

$ra = $_POST["auth"];
if ($ra) {
    session_regenerate_id();
    $Y = $ra["driver"];
    $Q = $ra["server"];
    $U = $ra["username"];
    $J = (string)$ra["password"];
    $j = $ra["db"];
    set_password($Y, $Q, $U, $J);
    $_SESSION["db"][$Y][$Q][$U][$j] = true;
    if ($ra["permanent"]) {
        $y = base64_encode($Y) . "-" . base64_encode($Q) . "-" . base64_encode($U) . "-" . base64_encode($j);
        $zd = $c->permanentLogin(true);
        $rd[$y] = "$y:" . base64_encode($zd ? encrypt_string($J, $zd) : "");
        cookie("adminer_permanent", implode(" ", $rd));
    }
    if (count($_POST) == 1 || DRIVER != $Y || SERVER != $Q || $_GET["username"] !== $U || DB != $j) redirect(auth_url($Y, $Q, $U, $j));
} elseif ($_POST["logout"]) {
    if ($dc && !verify_token()) {
        page_header(lang(58), lang(60));
        page_footer("db");
        exit;
    } else {
        foreach (array("pwds", "db", "dbs", "queries") as $y) set_session($y, null);
        unset_permanent();
        redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), lang(61) . ' ' . lang(62));
    }
} elseif ($rd && !$_SESSION["pwds"]) {
    session_regenerate_id();
    $zd = $c->permanentLogin();
    foreach ($rd
             as $y => $W) {
        list(, $Ha) = explode(":", $W);
        list($Y, $Q, $U, $j) = array_map('base64_decode', explode("-", $y));
        set_password($Y, $Q, $U, decrypt_string(base64_decode($Ha), $zd));
        $_SESSION["db"][$Y][$Q][$U][$j] = true;
    }
}
function
unset_permanent()
{
    global $rd;
    foreach ($rd
             as $y => $W) {
        list($Y, $Q, $U, $j) = array_map('base64_decode', explode("-", $y));
        if ($Y == DRIVER && $Q == SERVER && $U == $_GET["username"] && $j == DB) unset($rd[$y]);
    }
    cookie("adminer_permanent", implode(" ", $rd));
}

function
auth_error($l)
{
    global $c, $dc;
    $ae = session_name();
    if (isset($_GET["username"])) {
        header("HTTP/1.1 403 Forbidden");
        if (($_COOKIE[$ae] || $_GET[$ae]) && !$dc) $l = lang(63); else {
            restart_session();
            add_invalid_login();
            $J = get_password();
            if ($J !== null) {
                if ($J === false) $l .= '<br>' . lang(64, target_blank(), '<code>permanentLogin()</code>');
                set_password(DRIVER, SERVER, $_GET["username"], null);
            }
            unset_permanent();
        }
    }
    if (!$_COOKIE[$ae] && $_GET[$ae] && ini_bool("session.use_only_cookies")) $l = lang(65);
    $od = session_get_cookie_params();
    cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()), $od["lifetime"]);
    page_header(lang(32), $l, null);
    echo "<form action='' method='post'>\n", "<div>";
    if (hidden_fields($_POST, array("auth"))) echo "<p class='message'>" . lang(66) . "\n";
    echo "</div>\n";
    $c->loginForm();
    echo "</form>\n";
    page_footer("auth");
    exit;
}

if (isset($_GET["username"]) && !class_exists("Min_DB")) {
    unset($_SESSION["pwds"][DRIVER]);
    unset_permanent();
    page_header(lang(67), lang(68, implode(", ", $vd)), false);
    page_footer("auth");
    exit;
}
stop_session(true);
if (isset($_GET["username"])) {
    list($ic, $td) = explode(":", SERVER, 2);
    if (is_numeric($td) && $td < 1024) auth_error(lang(69));
    check_invalid_login();
    $h = connect();
    $k = new
    Min_Driver($h);
}
$Hc = null;
if (!is_object($h) || ($Hc = $c->login($_GET["username"], get_password())) !== true) {
    $l = (is_string($h) ? h($h) : (is_string($Hc) ? $Hc : lang(70)));
    auth_error($l . (preg_match('~^ | $~', get_password()) ? '<br>' . lang(71) : ''));
}
if ($ra && $_POST["token"]) $_POST["token"] = $He;
$l = '';
if ($_POST) {
    if (!verify_token()) {
        $pc = "max_input_vars";
        $Pc = ini_get($pc);
        if (extension_loaded("suhosin")) {
            foreach (array("suhosin.request.max_vars", "suhosin.post.max_vars") as $y) {
                $W = ini_get($y);
                if ($W && (!$Pc || $W < $Pc)) {
                    $pc = $y;
                    $Pc = $W;
                }
            }
        }
        $l = (!$_POST["token"] && $Pc ? lang(72, "'$pc'") : lang(60) . ' ' . lang(73));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $l = lang(74, "'post_max_size'");
    if (isset($_GET["sql"])) $l .= ' ' . lang(75);
}
function
email_header($ec)
{
    return "=?UTF-8?B?" . base64_encode($ec) . "?=";
}

function
send_mail($sb, $pe, $C, $Vb = "", $Jb = array())
{
    $yb = (DIRECTORY_SEPARATOR == "/" ? "\n" : "\r\n");
    $C = str_replace("\n", $yb, wordwrap(str_replace("\r", "", "$C\n")));
    $Ba = uniqid("boundary");
    $qa = "";
    foreach ((array)$Jb["error"] as $y => $W) {
        if (!$W) $qa .= "--$Ba$yb" . "Content-Type: " . str_replace("\n", "", $Jb["type"][$y]) . $yb . "Content-Disposition: attachment; filename=\"" . preg_replace('~["\n]~', '', $Jb["name"][$y]) . "\"$yb" . "Content-Transfer-Encoding: base64$yb$yb" . chunk_split(base64_encode(file_get_contents($Jb["tmp_name"][$y])), 76, $yb) . $yb;
    }
    $ya = "";
    $fc = "Content-Type: text/plain; charset=utf-8$yb" . "Content-Transfer-Encoding: 8bit";
    if ($qa) {
        $qa .= "--$Ba--$yb";
        $ya = "--$Ba$yb$fc$yb$yb";
        $fc = "Content-Type: multipart/mixed; boundary=\"$Ba\"";
    }
    $fc .= $yb . "MIME-Version: 1.0$yb" . "X-Mailer: Adminer Editor" . ($Vb ? $yb . "From: " . str_replace("\n", "", $Vb) : "");
    return
        mail($sb, email_header($pe), $ya . $C . $qa, $fc);
}

function
like_bool($m)
{
    return
        preg_match("~bool|(tinyint|bit)\\(1\\)~", $m["full_type"]);
}

$h->select_db($c->database());
$bd = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";
$mb[DRIVER] = lang(32);
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) $_GET["edit"] = $_GET["select"];
if (isset($_GET["download"])) {
    $b = $_GET["download"];
    $n = fields($b);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . friendly_url("$b-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
    $P = array(idf_escape($_GET["field"]));
    $L = $k->select($b, $P, array(where($_GET, $n)), $P);
    $N = ($L ? $L->fetch_row() : array());
    echo $k->value($N[0], $n[$_GET["field"]]);
    exit;
} elseif (isset($_GET["edit"])) {
    $b = $_GET["edit"];
    $n = fields($b);
    $Z = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $n) : "") : where($_GET, $n));
    $Xe = (isset($_GET["select"]) ? $_POST["edit"] : $Z);
    foreach ($n
             as $E => $m) {
        if (!isset($m["privileges"][$Xe ? "update" : "insert"]) || $c->fieldName($m) == "") unset($n[$E]);
    }
    if ($_POST && !$l && !isset($_GET["select"])) {
        $A = $_POST["referer"];
        if ($_POST["insert"]) $A = ($Xe ? null : $_SERVER["REQUEST_URI"]); elseif (!preg_match('~^.+&select=.+$~', $A)) $A = ME . "select=" . urlencode($b);
        $v = indexes($b);
        $Se = unique_array($_GET["where"], $v);
        $Ed = "\nWHERE $Z";
        if (isset($_POST["delete"])) queries_redirect($A, lang(76), $k->delete($b, $Ed, !$Se)); else {
            $R = array();
            foreach ($n
                     as $E => $m) {
                $W = process_input($m);
                if ($W !== false && $W !== null) $R[idf_escape($E)] = $W;
            }
            if ($Xe) {
                if (!$R) redirect($A);
                queries_redirect($A, lang(77), $k->update($b, $R, $Ed, !$Se));
                if (is_ajax()) {
                    page_headers();
                    page_messages($l);
                    exit;
                }
            } else {
                $L = $k->insert($b, $R);
                $Cc = ($L ? last_id() : 0);
                queries_redirect($A, lang(78, ($Cc ? " $Cc" : "")), $L);
            }
        }
    }
    $N = null;
    if ($_POST["save"]) $N = (array)$_POST["fields"]; elseif ($Z) {
        $P = array();
        foreach ($n
                 as $E => $m) {
            if (isset($m["privileges"]["select"])) {
                $oa = convert_field($m);
                if ($_POST["clone"] && $m["auto_increment"]) $oa = "''";
                if ($x == "sql" && preg_match("~enum|set~", $m["type"])) $oa = "1*" . idf_escape($E);
                $P[] = ($oa ? "$oa AS " : "") . idf_escape($E);
            }
        }
        $N = array();
        if (!support("table")) $P = array("*");
        if ($P) {
            $L = $k->select($b, $P, array($Z), $P, array(), (isset($_GET["select"]) ? 2 : 1));
            if (!$L) $l = error(); else {
                $N = $L->fetch_assoc();
                if (!$N) $N = false;
            }
            if (isset($_GET["select"]) && (!$N || $L->fetch_assoc())) $N = null;
        }
    }
    if (!support("table") && !$n) {
        if (!$Z) {
            $L = $k->select($b, array("*"), $Z, array("*"));
            $N = ($L ? $L->fetch_assoc() : false);
            if (!$N) $N = array($k->primary => "");
        }
        if ($N) {
            foreach ($N
                     as $y => $W) {
                if (!$Z) $N[$y] = null;
                $n[$y] = array("field" => $y, "null" => ($y != $k->primary), "auto_increment" => ($y == $k->primary));
            }
        }
    }
    edit_form($b, $n, $N, $Xe);
} elseif (isset($_GET["select"])) {
    $b = $_GET["select"];
    $T = table_status1($b);
    $v = indexes($b);
    $n = fields($b);
    $Sb = column_foreign_keys($b);
    $ad = $T["Oid"];
    parse_str($_COOKIE["adminer_import"], $ia);
    $Od = array();
    $f = array();
    $ze = null;
    foreach ($n
             as $y => $m) {
        $E = $c->fieldName($m);
        if (isset($m["privileges"]["select"]) && $E != "") {
            $f[$y] = html_entity_decode(strip_tags($E), ENT_QUOTES);
            if (is_shortable($m)) $ze = $c->selectLengthProcess();
        }
        $Od += $m["privileges"];
    }
    list($P, $r) = $c->selectColumnsProcess($f, $v);
    $w = count($r) < count($P);
    $Z = $c->selectSearchProcess($n, $v);
    $H = $c->selectOrderProcess($n, $v);
    $z = $c->selectLimitProcess();
    if ($_GET["val"] && is_ajax()) {
        header("Content-Type: text/plain; charset=utf-8");
        foreach ($_GET["val"] as $Te => $N) {
            $oa = convert_field($n[key($N)]);
            $P = array($oa ? $oa : idf_escape(key($N)));
            $Z[] = where_check($Te, $n);
            $M = $k->select($b, $P, $Z, $P);
            if ($M) echo
            reset($M->fetch_row());
        }
        exit;
    }
    $xd = $Ve = null;
    foreach ($v
             as $nc) {
        if ($nc["type"] == "PRIMARY") {
            $xd = array_flip($nc["columns"]);
            $Ve = ($P ? $xd : array());
            foreach ($Ve
                     as $y => $W) {
                if (in_array(idf_escape($y), $P)) unset($Ve[$y]);
            }
            break;
        }
    }
    if ($ad && !$xd) {
        $xd = $Ve = array($ad => 0);
        $v[] = array("type" => "PRIMARY", "columns" => array($ad));
    }
    if ($_POST && !$l) {
        $if = $Z;
        if (!$_POST["all"] && is_array($_POST["check"])) {
            $Ga = array();
            foreach ($_POST["check"] as $Ea) $Ga[] = where_check($Ea, $n);
            $if[] = "((" . implode(") OR (", $Ga) . "))";
        }
        $if = ($if ? "\nWHERE " . implode(" AND ", $if) : "");
        if ($_POST["export"]) {
            cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
            dump_headers($b);
            $c->dumpTable($b, "");
            $Vb = ($P ? implode(", ", $P) : "*") . convert_fields($f, $n, $P) . "\nFROM " . table($b);
            $Yb = ($r && $w ? "\nGROUP BY " . implode(", ", $r) : "") . ($H ? "\nORDER BY " . implode(", ", $H) : "");
            if (!is_array($_POST["check"]) || $xd) $K = "SELECT $Vb$if$Yb"; else {
                $Re = array();
                foreach ($_POST["check"] as $W) $Re[] = "(SELECT" . limit($Vb, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($W, $n) . $Yb, 1) . ")";
                $K = implode(" UNION ALL ", $Re);
            }
            $c->dumpData($b, "table", $K);
            exit;
        }
        if (!$c->selectEmailProcess($Z, $Sb)) {
            if ($_POST["save"] || $_POST["delete"]) {
                $L = true;
                $ja = 0;
                $R = array();
                if (!$_POST["delete"]) {
                    foreach ($f
                             as $E => $W) {
                        $W = process_input($n[$E]);
                        if ($W !== null && ($_POST["clone"] || $W !== false)) $R[idf_escape($E)] = ($W !== false ? $W : idf_escape($E));
                    }
                }
                if ($_POST["delete"] || $R) {
                    if ($_POST["clone"]) $K = "INTO " . table($b) . " (" . implode(", ", array_keys($R)) . ")\nSELECT " . implode(", ", $R) . "\nFROM " . table($b);
                    if ($_POST["all"] || ($xd && is_array($_POST["check"])) || $w) {
                        $L = ($_POST["delete"] ? $k->delete($b, $if) : ($_POST["clone"] ? queries("INSERT $K$if") : $k->update($b, $R, $if)));
                        $ja = $h->affected_rows;
                    } else {
                        foreach ((array)$_POST["check"] as $W) {
                            $hf = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($W, $n);
                            $L = ($_POST["delete"] ? $k->delete($b, $hf, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($b, $K, $hf)) : $k->update($b, $R, $hf, 1)));
                            if (!$L) break;
                            $ja += $h->affected_rows;
                        }
                    }
                }
                $C = lang(79, $ja);
                if ($_POST["clone"] && $L && $ja == 1) {
                    $Cc = last_id();
                    if ($Cc) $C = lang(78, " $Cc");
                }
                queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $C, $L);
                if (!$_POST["delete"]) {
                    edit_form($b, $n, (array)$_POST["fields"], !$_POST["clone"]);
                    page_footer();
                    exit;
                }
            } elseif (!$_POST["import"]) {
                if (!$_POST["val"]) $l = lang(80); else {
                    $L = true;
                    $ja = 0;
                    foreach ($_POST["val"] as $Te => $N) {
                        $R = array();
                        foreach ($N
                                 as $y => $W) {
                            $y = bracket_escape($y, 1);
                            $R[idf_escape($y)] = (preg_match('~char|text~', $n[$y]["type"]) || $W != "" ? $c->processInput($n[$y], $W) : "NULL");
                        }
                        $L = $k->update($b, $R, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($Te, $n), !$w && !$xd, " ");
                        if (!$L) break;
                        $ja += $h->affected_rows;
                    }
                    queries_redirect(remove_from_uri(), lang(79, $ja), $L);
                }
            } elseif (!is_string($Ib = get_file("csv_file", true))) $l = upload_error($Ib);
            elseif (!preg_match('~~u', $Ib)) $l = lang(81);
            else {
                cookie("adminer_import", "output=" . urlencode($ia["output"]) . "&format=" . urlencode($_POST["separator"]));
                $L = true;
                $Oa = array_keys($n);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $Ib, $Lc);
                $ja = count($Lc[0]);
                $k->begin();
                $Xd = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
                $O = array();
                foreach ($Lc[0] as $y => $W) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$Xd]*)$Xd~", $W . $Xd, $Mc);
                    if (!$y && !array_diff($Mc[1], $Oa)) {
                        $Oa = $Mc[1];
                        $ja--;
                    } else {
                        $R = array();
                        foreach ($Mc[1] as $s => $La) $R[idf_escape($Oa[$s])] = ($La == "" && $n[$Oa[$s]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $La))));
                        $O[] = $R;
                    }
                }
                $L = (!$O || $k->insertUpdate($b, $O, $xd));
                if ($L) $L = $k->commit();
                queries_redirect(remove_from_uri("page"), lang(82, $ja), $L);
                $k->rollback();
            }
        }
    }
    $ue = $c->tableName($T);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else
        page_header(lang(44) . ": $ue", $l);
    $R = null;
    if (isset($Od["insert"]) || !support("table")) {
        $R = "";
        foreach ((array)$_GET["where"] as $W) {
            if ($Sb[$W["col"]] && count($Sb[$W["col"]]) == 1 && ($W["op"] == "=" || (!$W["op"] && !preg_match('~[_%]~', $W["val"])))) $R .= "&set" . urlencode("[" . bracket_escape($W["col"]) . "]") . "=" . urlencode($W["val"]);
        }
    }
    $c->selectLinks($T, $R);
    if (!$f && support("table")) echo "<p class='error'>" . lang(83) . ($n ? "." : ": " . error()) . "\n"; else {
        echo "<form action='' id='form'>\n", "<div style='display: none;'>";
        hidden_fields_get();
        echo(DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
        echo '<input type="hidden" name="select" value="' . h($b) . '">', "</div>\n";
        $c->selectColumnsPrint($P, $f);
        $c->selectSearchPrint($Z, $f, $v);
        $c->selectOrderPrint($H, $f, $v);
        $c->selectLimitPrint($z);
        $c->selectLengthPrint($ze);
        $c->selectActionPrint($v);
        echo "</form>\n";
        $I = $_GET["page"];
        if ($I == "last") {
            $Ub = $h->result(count_rows($b, $Z, $w, $r));
            $I = floor(max(0, $Ub - 1) / $z);
        }
        $Sd = $P;
        $Xb = $r;
        if (!$Sd) {
            $Sd[] = "*";
            $Ua = convert_fields($f, $n, $P);
            if ($Ua) $Sd[] = substr($Ua, 2);
        }
        foreach ($P
                 as $y => $W) {
            $m = $n[idf_unescape($W)];
            if ($m && ($oa = convert_field($m))) $Sd[$y] = "$oa AS $W";
        }
        if (!$w && $Ve) {
            foreach ($Ve
                     as $y => $W) {
                $Sd[] = idf_escape($y);
                if ($Xb) $Xb[] = idf_escape($y);
            }
        }
        $L = $k->select($b, $Sd, $Z, $Xb, $H, $z, $I, true);
        if (!$L) echo "<p class='error'>" . error() . "\n"; else {
            if ($x == "mssql" && $I) $L->seek($z * $I);
            $ub = array();
            echo "<form action='' method='post' enctype='multipart/form-data'>\n";
            $O = array();
            while ($N = $L->fetch_assoc()) {
                if ($I && $x == "oracle") unset($N["RNUM"]);
                $O[] = $N;
            }
            if ($_GET["page"] != "last" && $z != "" && $r && $w && $x == "sql") $Ub = $h->result(" SELECT FOUND_ROWS()");
            if (!$O) echo "<p class='message'>" . lang(12) . "\n"; else {
                $xa = $c->backwardKeys($b, $ue);
                echo "<div class='scrollable'>", "<table id='table' cellspacing='0' class='nowrap checkable'>", script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"), "<thead><tr>" . (!$r && $P ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . lang(84) . "</a>");
                $Vc = array();
                $Wb = array();
                reset($P);
                $Gd = 1;
                foreach ($O[0] as $y => $W) {
                    if (!isset($Ve[$y])) {
                        $W = $_GET["columns"][key($P)];
                        $m = $n[$P ? ($W ? $W["col"] : current($P)) : $y];
                        $E = ($m ? $c->fieldName($m, $Gd) : ($W["fun"] ? "*" : $y));
                        if ($E != "") {
                            $Gd++;
                            $Vc[$y] = $E;
                            $e = idf_escape($y);
                            $jc = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($y);
                            $gb = "&desc%5B0%5D=1";
                            echo "<th>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""), '<a href="' . h($jc . ($H[0] == $e || $H[0] == $y || (!$H && $w && $r[0] == $e) ? $gb : '')) . '">';
                            echo
                                apply_sql_function($W["fun"], $E) . "</a>";
                            echo "<span class='column hidden'>", "<a href='" . h($jc . $gb) . "' title='" . lang(85) . "' class='text'> ↓</a>";
                            if (!$W["fun"]) {
                                echo '<a href="#fieldset-search" title="' . lang(39) . '" class="text jsonly"> =</a>', script("qsl('a').onclick = partial(selectSearch, '" . js_escape($y) . "');");
                            }
                            echo "</span>";
                        }
                        $Wb[$y] = $W["fun"];
                        next($P);
                    }
                }
                $Fc = array();
                if ($_GET["modify"]) {
                    foreach ($O
                             as $N) {
                        foreach ($N
                                 as $y => $W) $Fc[$y] = max($Fc[$y], min(40, strlen(utf8_decode($W))));
                    }
                }
                echo ($xa ? "<th>" . lang(86) : "") . "</thead>\n";
                if (is_ajax()) {
                    if ($z % 2 == 1 && $I % 2 == 1) odd();
                    ob_end_clean();
                }
                foreach ($c->rowDescriptions($O, $Sb) as $D => $N) {
                    $Se = unique_array($O[$D], $v);
                    if (!$Se) {
                        $Se = array();
                        foreach ($O[$D] as $y => $W) {
                            if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $y)) $Se[$y] = $W;
                        }
                    }
                    $Te = "";
                    foreach ($Se
                             as $y => $W) {
                        if (($x == "sql" || $x == "pgsql") && preg_match('~char|text|enum|set~', $n[$y]["type"]) && strlen($W) > 64) {
                            $y = (strpos($y, '(') ? $y : idf_escape($y));
                            $y = "MD5(" . ($x != 'sql' || preg_match("~^utf8~", $n[$y]["collation"]) ? $y : "CONVERT($y USING " . charset($h) . ")") . ")";
                            $W = md5($W);
                        }
                        $Te .= "&" . ($W !== null ? urlencode("where[" . bracket_escape($y) . "]") . "=" . urlencode($W) : "null%5B%5D=" . urlencode($y));
                    }
                    echo "<tr" . odd() . ">" . (!$r && $P ? "" : "<td>" . checkbox("check[]", substr($Te, 1), in_array(substr($Te, 1), (array)$_POST["check"])) . ($w || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($b) . $Te) . "' class='edit'>" . lang(87) . "</a>"));
                    foreach ($N
                             as $y => $W) {
                        if (isset($Vc[$y])) {
                            $m = $n[$y];
                            $W = $k->value($W, $m);
                            if ($W != "" && (!isset($ub[$y]) || $ub[$y] != "")) $ub[$y] = (is_mail($W) ? $Vc[$y] : "");
                            $_ = "";
                            if (preg_match('~blob|bytea|raw|file~', $m["type"]) && $W != "") $_ = ME . 'download=' . urlencode($b) . '&field=' . urlencode($y) . $Te;
                            if (!$_ && $W !== null) {
                                foreach ((array)$Sb[$y] as $Rb) {
                                    if (count($Sb[$y]) == 1 || end($Rb["source"]) == $y) {
                                        $_ = "";
                                        foreach ($Rb["source"] as $s => $fe) $_ .= where_link($s, $Rb["target"][$s], $O[$D][$fe]);
                                        $_ = ($Rb["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($Rb["db"]), ME) : ME) . 'select=' . urlencode($Rb["table"]) . $_;
                                        if ($Rb["ns"]) $_ = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($Rb["ns"]), $_);
                                        if (count($Rb["source"]) == 1) break;
                                    }
                                }
                            }
                            if ($y == "COUNT(*)") {
                                $_ = ME . "select=" . urlencode($b);
                                $s = 0;
                                foreach ((array)$_GET["where"] as $V) {
                                    if (!array_key_exists($V["col"], $Se)) $_ .= where_link($s++, $V["col"], $V["val"], $V["op"]);
                                }
                                foreach ($Se
                                         as $vc => $V) $_ .= where_link($s++, $vc, $V);
                            }
                            $W = select_value($W, $_, $m, $ze);
                            $t = h("val[$Te][" . bracket_escape($y) . "]");
                            $X = $_POST["val"][$Te][bracket_escape($y)];
                            $qb = !is_array($N[$y]) && is_utf8($W) && $O[$D][$y] == $N[$y] && !$Wb[$y];
                            $ye = preg_match('~text|lob~', $m["type"]);
                            if (($_GET["modify"] && $qb) || $X !== null) {
                                $ac = h($X !== null ? $X : $N[$y]);
                                echo "<td>" . ($ye ? "<textarea name='$t' cols='30' rows='" . (substr_count($N[$y], "\n") + 1) . "'>$ac</textarea>" : "<input name='$t' value='$ac' size='$Fc[$y]'>");
                            } else {
                                $Ic = strpos($W, "<i>…</i>");
                                echo "<td id='$t' data-text='" . ($Ic ? 2 : ($ye ? 1 : 0)) . "'" . ($qb ? "" : " data-warning='" . h(lang(88)) . "'") . ">$W</td>";
                            }
                        }
                    }
                    if ($xa) echo "<td>";
                    $c->backwardKeysPrint($xa, $O[$D]);
                    echo "</tr>\n";
                }
                if (is_ajax()) exit;
                echo "</table>\n", "</div>\n";
            }
            if (!is_ajax()) {
                if ($O || $I) {
                    $Bb = true;
                    if ($_GET["page"] != "last") {
                        if ($z == "" || (count($O) < $z && ($O || !$I))) $Ub = ($I ? $I * $z : 0) + count($O); elseif ($x != "sql" || !$w) {
                            $Ub = ($w ? false : found_rows($T, $Z));
                            if ($Ub < max(1e4, 2 * ($I + 1) * $z)) $Ub = reset(slow_query(count_rows($b, $Z, $w, $r))); else$Bb = false;
                        }
                    }
                    $md = ($z != "" && ($Ub === false || $Ub > $z || $I));
                    if ($md) {
                        echo(($Ub === false ? count($O) + 1 : $Ub - $I * $z) > $z ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($I + 1)) . '" class="loadmore">' . lang(89) . '</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$z) . ", '" . lang(90) . "…');", "") : ''), "\n";
                    }
                }
                echo "<div class='footer'><div>\n";
                if ($O || $I) {
                    if ($md) {
                        $Nc = ($Ub === false ? $I + (count($O) >= $z ? 2 : 1) : floor(($Ub - 1) / $z));
                        echo "<fieldset>";
                        if ($x != "simpledb") {
                            echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . lang(91) . "</a></legend>", script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . lang(91) . "', '" . ($I + 1) . "')); return false; };"), pagination(0, $I) . ($I > 5 ? " …" : "");
                            for ($s = max(1, $I - 4); $s < min($Nc, $I + 5); $s++) echo
                            pagination($s, $I);
                            if ($Nc > 0) {
                                echo($I + 5 < $Nc ? " …" : ""), ($Bb && $Ub !== false ? pagination($Nc, $I) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Nc'>" . lang(92) . "</a>");
                            }
                        } else {
                            echo "<legend>" . lang(91) . "</legend>", pagination(0, $I) . ($I > 1 ? " …" : ""), ($I ? pagination($I, $I) : ""), ($Nc > $I ? pagination($I + 1, $I) . ($Nc > $I + 1 ? " …" : "") : "");
                        }
                        echo "</fieldset>\n";
                    }
                    echo "<fieldset>", "<legend>" . lang(93) . "</legend>";
                    $kb = ($Bb ? "" : "~ ") . $Ub;
                    echo
                        checkbox("all", 1, 0, ($Ub !== false ? ($Bb ? "" : "~ ") . lang(94, $Ub) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$kb' : checked); selectCount('selected2', this.checked || !checked ? '$kb' : checked);") . "\n", "</fieldset>\n";
                    if ($c->selectCommandPrint()) {
                        echo '<fieldset', ($_GET["modify"] ? '' : ' class="jsonly"'), '><legend>', lang(84), '</legend><div>
<input type="submit" value="', lang(14), '"', ($_GET["modify"] ? '' : ' title="' . lang(80) . '"'), '>
</div></fieldset>
<fieldset><legend>', lang(95), ' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="', lang(10), '">
<input type="submit" name="clone" value="', lang(96), '">
<input type="submit" name="delete" value="', lang(18), '">', confirm(), '</div></fieldset>
';
                    }
                    $Tb = $c->dumpFormat();
                    foreach ((array)$_GET["columns"] as $e) {
                        if ($e["fun"]) {
                            unset($Tb['sql']);
                            break;
                        }
                    }
                    if ($Tb) {
                        print_fieldset("export", lang(97) . " <span id='selected2'></span>");
                        $kd = $c->dumpOutput();
                        echo($kd ? html_select("output", $kd, $ia["output"]) . " " : ""), html_select("format", $Tb, $ia["format"]), " <input type='submit' name='export' value='" . lang(97) . "'>\n", "</div></fieldset>\n";
                    }
                    $c->selectEmailPrint(array_filter($ub, 'strlen'), $f);
                }
                echo "</div></div>\n";
                if ($c->selectImportPrint()) {
                    echo "<div>", "<a href='#import'>" . lang(98) . "</a>", script("qsl('a').onclick = partial(toggle, 'import');", ""), "<span id='import' class='hidden'>: ", "<input type='file' name='csv_file'> ", html_select("separator", array("csv" => "CSV,", "csv;" => "CSV;", "tsv" => "TSV"), $ia["format"], 1);
                    echo " <input type='submit' name='import' value='" . lang(98) . "'>", "</span>", "</div>";
                }
                echo "<input type='hidden' name='token' value='$He'>\n", "</form>\n", (!$r && $P ? "" : script("tableCheck();"));
            }
        }
    }
    if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET["script"])) {
    if ($_GET["script"] == "kill") $h->query("KILL " . number($_POST["kill"])); elseif (list($S, $t, $E) = $c->_foreignColumn(column_foreign_keys($_GET["source"]), $_GET["field"])) {
        $z = 11;
        $L = $h->query("SELECT $t, $E FROM " . table($S) . " WHERE " . (preg_match('~^[0-9]+$~', $_GET["value"]) ? "$t = $_GET[value] OR " : "") . "$E LIKE " . q("$_GET[value]%") . " ORDER BY 2 LIMIT $z");
        for ($s = 1; ($N = $L->fetch_row()) && $s < $z; $s++) echo "<a href='" . h(ME . "edit=" . urlencode($S) . "&where" . urlencode("[" . bracket_escape(idf_unescape($t)) . "]") . "=" . urlencode($N[0])) . "'>" . h($N[1]) . "</a><br>\n";
        if ($N) echo "...\n";
    }
    exit;
} else {
    page_header(lang(57), "", false);
    if ($c->homepage()) {
        echo "<form action='' method='post'>\n", "<p>" . lang(99) . ": <input type='search' name='query' value='" . h($_POST["query"]) . "'> <input type='submit' value='" . lang(39) . "'>\n";
        if ($_POST["query"] != "") search_tables();
        echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), '<thead><tr class="wrap">', '<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^tables\[/);", ""), '<th>' . lang(100), '<td>' . lang(101), "</thead>\n";
        foreach (table_status() as $S => $N) {
            $E = $c->tableName($N);
            if (isset($N["Engine"]) && $E != "") {
                echo '<tr' . odd() . '><td>' . checkbox("tables[]", $S, in_array($S, (array)$_POST["tables"], true)), "<th><a href='" . h(ME) . 'select=' . urlencode($S) . "'>$E</a>";
                $W = format_number($N["Rows"]);
                echo "<td align='right'><a href='" . h(ME . "edit=") . urlencode($S) . "'>" . ($N["Engine"] == "InnoDB" && $W ? "~ $W" : $W) . "</a>";
            }
        }
        echo "</table>\n", "</div>\n", "</form>\n", script("tableCheck();");
    }
}
page_footer();