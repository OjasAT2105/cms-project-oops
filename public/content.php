<?php
require_once("../classes/Database.php");
require_once("../classes/Subject.php");
require_once("../classes/Page.php");
include("../includes/header.php");

$subjectObj = new Subject();
$pageObj = new Page();

$sel_subj = $_GET['subj'] ?? "";
$sel_page = $_GET['page'] ?? "";
?>
<table id="structure">
    <tr>
        <td id="navigation">
           <ul class="subjects">
            <?php
            $subject_set = $subjectObj->getAllSubjects();
            while ($subject = $subject_set->fetch_assoc()) {
                echo "<li";
                if ($subject['id'] == $sel_subj) echo " class=\"selected\"";
                echo "><a href=\"content.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";

                echo "<ul class=\"pages\">";
                $page_set = $pageObj->getPagesForSubject($subject["id"]);
                while ($page = $page_set->fetch_assoc()) {
                    echo "<li";
                    if ($page['id'] == $sel_page) echo " class=\"selected\"";
                    echo "><a href=\"content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
                }
                echo "</ul>";
            }
            ?>
           </ul>
        </td>
        <td id="page"> 
            <h2>Content Area</h2>
            <?php echo $sel_subj; ?><br>
            <?php echo $sel_page; ?>
        </td>
    </tr>
</table>
<?php include("../includes/footer.php"); ?>
