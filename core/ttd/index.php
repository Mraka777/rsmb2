<?php
// absolute path to the openttd-installation or bin/-directory
$path = 'http://biathlon-manager.com/core/ttd/';

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Charset: ISO-8859-15');
// {{{ function stripslashes_deep(mixed)
/**
 * Applies stripslashes to an array.
 *
 * Applies stripslashes recursively to an array and returns the
 * new array.
 *
 * @param value The array to apply stripslashes on
 * @return The resulting array
 * @note From the php manual of stripslashes()
 */
function stripslashes_deep($value) {
    $value = is_array($value) ?
             array_map('stripslashes_deep', $value) :
             stripslashes($value);
    return $value;
}
// }}}
if (get_magic_quotes_gpc()) {
    $_GET = stripslashes_deep($_GET);
    $_POST = stripslashes_deep($_POST);
    $_COOKIE = stripslashes_deep($_COOKIE); 
}
if (!isset($path)) {
    die ('Configuration "path" is missing.');
}
if (!is_string($path)) {
    die ('Configuration "path" must be a string.');
}
if (!file_exists($path)) {
    die ('Configuration "path" must be point to a openttd installation (and must got chmod +x).');
}
if (!is_dir($path)) {
    die ('Configuration "path" must be a directory to the openttd installation.');
}
if (!is_readable($path)) {
    die ('The directory of the configuration "path" must be readable.');
}
// be sure it got a slash at the end
if (substr($path, -1) != DIRECTORY_SEPARATOR) {
    die ('Configuration "path" must be end by a '.DIRECTORY_SEPARATOR);
}
if (substr($path, -2, 1) == DIRECTORY_SEPARATOR) {
    die ('Configuration "path" must not be end with two '.DIRECTORY_SEPARATOR);
}
// check if it is absolute
if ($path != realpath($path).DIRECTORY_SEPARATOR) {
    die ('Configuration "path" must be an absolute path.');
}
// $path is now '/........openttd/', check if if contains the directory
// data/ and configuration file openttd.cfg
// openttd.cfg
if (!file_exists($path.'openttd.cfg')) {
    die ('Openttd configuration file "openttd.cfg" missing or directory doesn\'t have chmod +x.');
}
if (!is_file($path.'openttd.cfg')) {
    die ('Openttd configuration file "openttd.cfg" must be a file, but isn\'t.');
}
if (!is_readable($path.'openttd.cfg')) {
    die ('Openttd configuration file "openttd.cfg" must be readable.');
}
if (!is_writable($path.'openttd.cfg')) {
    die ('Openttd configuration file "openttd.cfg" must be writable for the webserver.');
}
// data/
if (!file_exists($path.'data')) {
    die ('Openttd data-directory is missing or bin-directory doesn\'t have chmod +x.');
}
if (!is_dir($path.'data')) {
    die ('Openttd data-directory isn\'t a directory, but should be.');
}
if (!is_readable($path.'data')) {
    die ('Openttd data-directory must be readable.');
}
// parse the file, cannot use parse_ini_file as it doesn't work properbly
// with the openttd config format
$group = null;
$config = array();
$newgrfconfig = array();
$filecontent = file($path.'openttd.cfg');
foreach ($filecontent as $line) {
    $line = trim($line);
    if (preg_match('~^\[(.*)\]$~', $line, $matches)) {
        $group = $matches[1];
    }
    if (is_null($group)) {
        die ('Configuration file must be start with a group.');
    }
    if (!isset($config[$group])) {
        $config[$group] = array();
    }
    if ('newgrf' != $group and preg_match('~^(\S+) = (.*)$~', $line, $matches)) {
        // normal ini setting
        $config[$group][$matches[1]] = $matches[2];
    } else {
        // newgrf line
        $split = explode(' = ', $line, 2);
        $config[$group][] = $split[0];
        if (isset($split[1])) {
            $newgrfconfig[$split[0]] = $split[1];
        } 
    }
}
if (!isset($config['gameopt'])) {
    die ('Configuration [gameopt] missing.');
}
if (!isset($config['gameopt']['diff_custom'])) {
    die ('Configuration [gameopt]->diff_custom missing.');
}
if (!isset($config['newgrf'])) {
    die ('Configuration [newgrf] missing.');
}
$settings = explode(',', $config['gameopt']['diff_custom']);
if (18 != count($settings)) {
    die ('Configuration [gameopt]->diff_custom is invalid, must containts 18 values.');
}
if ('Save' == @$_POST['formaction']) {
    if (!isset($_POST['Settings'], $_POST['Difficult'], $_POST['Patches'], $_POST['Numbers'])) {
        die ('Invalid form.');
    }
    if (!is_array($_POST['Difficult']) or
            !is_array($_POST['Settings']) or
            !is_array($_POST['Patches']) or
            !is_array($_POST['Numbers'])) {
        die ('Invalid form.');
    }
    if (count($_POST['Difficult']) != 18) {
        die ('Invalid form.');
    }
    // load file and change content, don't touch unused lines
    $content = file($path.'openttd.cfg');
    // I hope the setting names doesn't interfect each other...
    $values = $_POST['Settings'] + $_POST['Patches'] + $_POST['Numbers'];
    // rip the directory from the newgrfs
    $newgrfs = array();
    if (isset($_POST['NewGRF']) and is_array($_POST['NewGRF'])) {
        foreach ($_POST['NewGRF'] as $file) {
            $newgrfs[] = str_replace($path.'data'.DIRECTORY_SEPARATOR, '', $file);
        } 
    }
    $innewgrf = false;
    $afternewgrf = false;
    natsort($newgrfs);
    foreach ($content as $key => $value) {
        $content[$key] = $value = trim($value);
        if ('' == $value and false) {
            unset($content[$key]);
            continue;
        }
        if (substr($value, 0, 1) == '#') {
            continue;
        }
        if (0 === strpos($value, 'diff_custom')) {
            $content[$key] = 'diff_custom = '.implode(',', $_POST['Difficult']);
        }
        if ((!$innewgrf or $afternewgrf) and $pos = strpos($value,' = ')) { // note 0 == false, but this doesn't matter here
            // found a ' = '-> setting, checking do so
            $setting = substr($value, 0, $pos);
            if (isset($values[$setting])) {
                $content[$key] = $setting.' = '.$values[$setting];
            }
        } else {
            // it is a newgrf or new group
            if (preg_match('~\[(.*)\]~', $value, $matches)) {
                // its a group
                if ($matches[1] == 'newgrf') {
                    $innewgrf = true;
                }
                if ($innewgrf and $matches[1] != 'newgrf') {
                    $afternewgrf = true;
                }
                if ($afternewgrf and $innewgrf) {
                    // add the missing files, now I'm cheating
                    $to_add = '';
                    foreach ($newgrfs as $grf) {
                        if ('' == $param = trim($_POST['NewGRFParameter'][$path.'data'.DIRECTORY_SEPARATOR.$grf])) {
                            // no setting, save normal
                            $to_add .= $grf."\n";
                        } else {
                            // with parameter, save them
                            $to_add .= $grf." ".$param."\n";
                        } 
                    }
                    $to_add = trim($to_add);
                    $content[$key] = $to_add."\n".$value;
                    $innewgrf = false;
                }
                continue;
            }
            if ($innewgrf and !$afternewgrf) {
                // whatever we found here, delete it
                unset($content[$key]);
            }
        }
    }
    file_put_contents($path.'openttd.cfg', implode("\n", $content));
    die ('Configuration saved (if you don\'t see any errors :)).');
}
?><?php echo '<? xml version="1.0" encoding="ISO-8859-15"?>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type:" content="text/html; charset=ISO-8859-15" />
        <title>OpenTTD configuration tool</title>
        <style type="text/css">
label {
    display: block;
}
p.info {
    background-color: #9f9;
    border: 1px solid #090;
    padding: 1em;
}
li label {
    display: inline;
}
        </style>
    </head>
    <body>
        <h1>OpenTTD configuration tool</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <legend>Individual difficult settings</legend>
<?php
$settingnames = array('Maximum no. of competitors (AI)',
                      'Competitor start time',
                      'No. of towns',
                      'No. of industries',
                      'Maximum initial loan',
                      'Initial interest rate',
                      'Vehicle running costs',
                      'Construction speed of competitors',
                      'Intelligence of competitors',
                      'Vehicle breakdowns',
                      'Subsidy multiplier',
                      'Cost of construction',
                      'Terrain type',
                      'Quantity of sea/lakes',
                      'Economy',
                      'Train reversing',
                      'Disasters',
                      "City council's attitude towards area restructuring",
                      );
$settingvalues  = array(array('0 Computer player', '1 Computer player', '2 Computer player', '3 Computer player',
                              '4 Computer player', '5 Computer player', '6 Computer player', '7 Computer player'),
                        array('Now', 'After 3 months', 'After 6 months', 'After 9 months'),
                        array('Low', 'Normal', 'High'),
                        array('None', 'Low', 'Normal', 'High'),
                        array(500 => '500k £ (1Mil $)', 450 => '450k £ (900k $)', 400 => '400k £ (800k $)', 350 => '350k £ (700k $)',
                              300 => '300k £ (600k $)', 250 => '250k £ (500k $)', 200 => '200k £ (400k $)'),
                        array(2 => '2%', 3 => '3%', 4 => '4%'),
                        array('Low', 'Medium', 'High'),
                        array('Very low', 'Low', 'Medium', 'Fast'),
                        array('Low', 'Medium', 'High'),
                        array('None', 'Lower', 'Normal'),
                        array('1.5 x', '2.0 x', '3.0 x', '4.0 x'),
                        array('Low', 'Medium', 'High'),
                        array('Very low', 'Normal', 'High', 'Mountainous'),
                        array('Very low', 'Low', 'Medium', 'High'),
                        array('Steady', 'Fluctuating'),
                        array('At end of line, and at stations', 'At end of line only'),
                        array('Off', 'On'),
                        array('Permissive', 'Tolerant', 'Hostile'));
// okay, lets go...
foreach ($settingnames as $key => $value) { ?>
                <label><?php echo htmlentities($value); ?>
                    <select name="Difficult[<?php echo $key; ?>]">
    <?php foreach ($settingvalues[$key] as $index => $entry) { ?>
        <?php if ($index == $settings[$key] ) { ?>
                        <option value="<?php echo $index; ?>" selected="selected"><?php echo htmlentities($entry); ?></option>
        <?php } else { ?>
                        <option value="<?php echo $index; ?>"><?php echo htmlentities($entry); ?></option>
        <?php } ?>
    <?php } ?>
                    </select>
                </label>
<?php } ?>
            </fieldset>
            <fieldset>
                <legend>Game options</legend>
<?php
// yes, overwrite
$settingnames = array('diff_level' => 'Difficulty level',
                      'currency'   => 'Default currency for the server',
                      'units'      => 'Units',
                      'town_name'  => 'Language of town names',
                      'landscape'  => 'Climate/Landscape',    
                      //'snow_line'  => 'Snow line',
                      'autosave'   => 'Autosave interval',
                      'road_side'  => 'Side for road vehicles');
$settingvalues = array('diff_level' => array('Easy', 'Normal', 'Hard', 'Custom (above)'),
                       'currency'   => array('GBP' => 'Pounds (£)',
                                             'USD' => 'Dollars ($)',
                                             'EUR' => 'Euro',
                                             'YEN' => 'Yen (¥)',
                                             'ATS' => 'Austrian Shilling (ATS)',
                                             'BEF' => 'Belgian Franc (BEF)',
                                             'CHF' => 'Swiss Franc (CHF)',
                                             'CZK' => 'Czech Koruna (CZK)',
                                             'DEM' => 'Deutschmark (DEM)',
                                             'DKK' => 'Danish Krone (DKK)',
                                             'ESP' => 'Peseta (ESP)',
                                             'FIM' => 'Finnish Markka (FIM)',
                                             'FRF' => 'Franc (FRF)',
                                             'GRD' => 'Greek Drachma (GRD)',
                                             'HUF' => 'Hungaria Forint (HUF)',
                                             'ISK' => 'Icelandic Krona (ISK)',
                                             'ITL' => 'Italian Lira (ITL)', 
                                             'NLG' => 'Dutch Guilder (NLG)',
                                             'NOK' => 'Norwegen Krone (NOK)',
                                             'PLN' => 'Polish Zloty (PLN)',
                                             'ROL' => 'Romanian Leu (ROL)',
                                             'RUR' => 'Russian Rubles (RUR)',
                                             'SIT' => 'Slovenian Tolar (SIT)',
                                             'SEK' => 'Swedish Krona (SEK)',
                                             'YTL' => 'Turkish Lira (YTL)',
                                             'SKK' => 'Slovak Koruna (SKK)',
                                             'BRR' => 'Brazilian Real (BRL)',
                                             'custom' => 'Custom...'),
                        'units' => array('imperial' => 'Imperial', 'metric' => 'Metric', 'si' => 'SI'),
                        'town_name' => array('english' => 'English (Original)',
                                             'french'  => 'French',
                                             'german'  => 'German',
                                             'american' => 'English (Additional)',
                                             'latin'   => 'Latin',
                                             'silly'   => 'Silly',
                                             'swedish' => 'Swedish',
                                             'dutch'   => 'Dutch',
                                             'finnish' => 'Finnish',
                                             'polish'  => 'Polish',
                                             'slovakish' => 'Slovakish',
                                             'norwegian' => 'Norwegian',
                                             'hungarian' => 'Hungarian',
                                             'austrian' => 'Austrian',
                                             'romanian' => 'Romanian',
                                             'czech' => 'Czech',
                                             'swiss' => 'Swiss', 
                                             'danish' => 'Danish',
                                             'turkish' => 'Turkish',
                                             'italian' => 'Italian',
                                             'catalan' => 'Catalan'),
                        'landscape' => array('temperate' => 'Temperate landscape',
                                             'arctic' => 'Sub-arctit landscape',
                                             'tropic' => 'Sub-tropical landscape',
                                             'toyland' => 'Toyland landscape'),
                        'snow_line' => array(56 => 56),
                        'autosave'  => array('off' => 'Off', 'monthly' => 'Monthly', 'quarterly' => 'Quarterly',
                                             'half year' => 'Half year', 'yearly' => 'Yearly'),
                        'road_side' => array('left' => 'Left', 'right' => 'Right')
                       );
// lets go
foreach ($settingnames as $key => $value) { ?>
                <label><?php echo htmlentities($value); ?>
                    <select name="Settings[<?php echo $key; ?>]">
    <?php foreach ($settingvalues[$key] as $index => $entry) { ?>
        <?php if ($config['gameopt'][$key] == $index ) { ?>
                        <option value="<?php echo $index; ?>" selected="selected"><?php echo htmlentities($entry); ?></option>
        <?php } else { ?>
                        <option value="<?php echo $index; ?>"><?php echo htmlentities($entry); ?></option>
        <?php } ?>
    <?php } ?>
                    </select>
                </label>
<?php } ?>
            </fieldset>
            <fieldset>
                <legend>Patch settings</legend>
<?php
$settingnames = array('map_x' => 'X Size of the map',
                      'map_y' => 'Y Size of the map',
                      'town_layout' => 'Town street layout',
                      'town_growth_rate' => 'Town growth rate',
                      'wagon_speed_limits' => 'Enable wagon speed limit',
                      'land_generator' => 'Land generator',
                      'tgen_smoothness' => 'Smoothness of map (TerraGenesis)',
                      'raw_industry_construction' => 'Manual primary industry construction method',
                     );
$settingvalues = array('map_x' => array(6 => 64, 128, 256, 512, 1024, 2048),
                       'map_y' => array(6 => 64, 128, 256, 512, 1024, 2048),
                       'town_layout' => array('No streets', 'Original street algorithmus', 'Improved street layout', '2x2', '3x3'), 
                       'town_growth_rate' => array('None', 'Slow', 'Normal', 'Fast', 'Very fast'),
                       'wagon_speed_limits' => array('true' => 'True', 'false' => 'False'),
                       'land_generator' => array('Original', 'TerraGenesis'),
                       'tgen_smoothness' => array('Very Smooth', 'Smooth', 'Rough', 'Very Rough'),
                       'raw_industry_construction' => array('none', 'as other industries', 'prospecting'),
                   );
// lets go
foreach ($settingnames as $key => $value) { ?>
                <label><?php echo htmlentities($value); ?>
                    <select name="Patches[<?php echo $key; ?>]">
    <?php foreach ($settingvalues[$key] as $index => $entry) { ?>
        <?php if ($config['patches'][$key] == $index ) { ?>
                        <option value="<?php echo $index; ?>" selected="selected"><?php echo htmlentities($entry); ?></option>
        <?php } else { ?>
                        <option value="<?php echo $index; ?>"><?php echo htmlentities($entry); ?></option>
        <?php } ?>
    <?php } ?>
                    </select>
                </label>
<?php } ?>
<?php
// any "number" patch settings
$settingnames = array('max_trains' => 'Max trains per player',
                      'max_roadveh' => 'Max road vehicle per player',
                      'max_aircraft' => 'Max aircraft per player',
                      'max_ships' => 'Max ships per player',
                      'starting_year' => 'Year of game start',
                     );
// lets go
foreach ($settingnames as $key => $value) { ?>
                <label><?php echo htmlentities($value); ?>
                    <input name="Numbers[<?php echo $key; ?>]" value="<?php echo $config['patches'][$key] ?>" />
                </label>
<?php } ?>
            </fieldset>
            <fieldset>
                <legend>NewGRF settings</legend>
                <p class="info">
                    If you don't see newgrfs which should be displayed check the chmod for these files.
                    The webserver must read the files (+r) and the directories must be searchable (+rx).
                </p>
<?php
/**
 * Returns all newgrfs found in the given directory.
 *
 * This function returns all newgrfs found in the specific directory. The
 * given directory must be end with a DIRECTORY_SEPARATOR and must be absolute.
 * The files which were found will be absolute. If there is some kind of
 * error (doesn't exists, not readable, ...) it silently returns an
 * empty array (for a given or recursive directory).
 *
 * @param dir The directory to search in
 * @return An array of absolute filename
 */
function getNewGRFFiles($dir) {
    if (!file_exists($dir)) {
        return array();
    }
    if (!is_dir($dir)) {
        return array();
    }
    if (substr($dir, -1) != DIRECTORY_SEPARATOR) {
        return array();
    }
    if (substr($dir, -2, 1) == DIRECTORY_SEPARATOR) {
        return array();
    }
    // check if it is absolute
    if ($dir != realpath($dir).DIRECTORY_SEPARATOR) {
        return array();
    }
    if (!is_readable($dir)) {
        return array();
    }
    $d = dir($dir);
    $ret = array();
    while (false !== ($entry = $d->read())) {
        if ('.' == $entry or '..' == $entry) {
            continue;
        }
        if (is_dir($d->path.$entry)) {
            $ret = array_merge($ret, getNewGRFFiles($d->path.$entry.DIRECTORY_SEPARATOR));
            continue;
        }
        if (!is_file($d->path.$entry)) {
            continue;
        }
        if (!is_readable($d->path.$entry)) {
            continue;
        }
        $pathinfo = pathinfo($d->path.$entry);
        if (isset($pathinfo['extension']) and strtolower($pathinfo['extension']) == 'grf') {
            $ret[] = $d->path.$entry;
        }
    }
    $d->close();
    return $ret;
}
$files = getNewGRFFiles($path.'data'.DIRECTORY_SEPARATOR);
?>
            <ul>
<?php foreach ($files as $file) { ?>
    <?php if (in_array($short = str_replace($path.'data'.DIRECTORY_SEPARATOR, '', $file), $config['newgrf'])) { ?>
                <li><label><input type="checkbox" name="NewGRF[]" value="<?php echo htmlentities($file); ?>" checked="checked"/><?php echo htmlentities($short); ?></label>
    <?php } else { ?>
                <li><label><input type="checkbox" name="NewGRF[]" value="<?php echo htmlentities($file); ?>" /><?php echo htmlentities($short); ?></label>
    <?php } ?>
    <?php if (isset($newgrfconfig[str_replace($path.'data'.DIRECTORY_SEPARATOR, '', $file)])) { ?>
        <input type="text" name="NewGRFParameter[<?php echo $file; ?>]" value="<?php echo htmlentities($newgrfconfig[str_replace($path.'data'.DIRECTORY_SEPARATOR, '', $file)]); ?>" />
    <?php } else { ?>
        <input type="text" name="NewGRFParameter[<?php echo $file; ?>]" />
    <?php } ?>
    </li>
<?php } ?> 
            </ul>
            </fieldset>
            <input type="submit" name="formaction" value="Save" />
            <input type="reset" />
        </form>
        <address>
            OpenTTD configuration tool by Progman (Progman2002@gmx.de)
        </address>
    </body>
</html>
