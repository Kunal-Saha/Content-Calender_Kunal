<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://kunal-saha
 * @since      1.0.0
 *
 * @package    Content_calender_plugin
 * @subpackage Content_calender_plugin/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<?php
function wpac_settings_page_html() {
    //Check if current user have admin access.
    if(!is_admin()) {
        return;
    }
    ?>
        <div class="wrap">
            <h1 class="header"><?= esc_html(get_admin_page_title()); ?></h1>
            <form method='post'>
            <table>
                <tr>
                    <th><label for ="myDate">DATE</label></th>
                    <td><input type="Date" name="myDate"></td>
                </tr>
                <tr>
                    <th><label for ="myOccasion">Occasion</label></th>
                    <td><input type="text" name="myOccasion"></td>
                </tr>
                <tr>
                <th><label for ="myTitle">Post Title</label></th>
                    <td><input type="text" name="myTitle"></td>
                </tr>
                <tr>
                    <th><label for ="A_name">Author Name</label></th>
                    <td><select name="A_name" id="admin" required>
                    <?php
                    $users = get_users( array(
                        'fields' =>array( 'ID', 'display_name' )
                    ) );
                    foreach ($users as $user) {
                        echo '<option value="' . $user->ID . '">'. $user->display_name . '</option>';
                    }
                    ?>
                </select></td>
                </tr>
                <tr>
                    <th><label for ="reviewer">Reviewer</label></th>
                    <!-- <td><input type="name" name="reviewer"></td> -->
                    <td><select name="reviewer" id="reviewer" required>
                    <?php
                        $admins = get_users( array(
                            'role'  => 'administrator',
                            'fields'=> array( 'ID', 'display_name' )
                        ) );

                        foreach( $admins as $admin ) {
                            echo '<option value = "' . $admin->ID . '">' . $admin->display_name . '</option>';
                        }
                    ?>
                    </select></td>
                </tr>
            </table>
            <br>
                <?php
                    submit_button( "Schedule Post" );
                ?>
            <br>
            </form>
        </div>
        <style>
            .header{
                width: 96%;
                padding:10px; 
                text-align: center;
                background:#008080;
                color: black;
                font-weight: bold;
            }
            table {
                width: 96%;
                border-collapse: collapse;
                font-size: 16px;
                color: blue;
            }
            th, td {
                border: 3px solid magenta;
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: cyan;
            }
        </style>
    <?php

}

function print_schedule() {
    ?>

    <h1 class = "tab-title">Upcoming Events</h1>

    <?php

    global $wpdb;
    $table_name = $wpdb->prefix . 'events';

    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE date >= DATE( NOW() ) ORDER BY date");

    echo '<table id="upcoming-table" >';
    echo '<thead><tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr></thead>';
    foreach ( $results as $row ) {
        echo '<tr>';
        echo '<td>' . $row->id . '</td>';
		echo '<td>' . $row->date . '</td>';
		echo '<td>' . $row->occassion . '</td>';
		echo '<td>' . $row->post_title . '</td>';
		echo '<td>' . get_userdata($row->author)->user_login . '</td>';
		echo '<td>' . get_userdata($row->reviewer)->user_login . '</td>';
		echo '</tr>';
    }
    echo '</table>';


    ?>
    <h1 class="tab-title">Closed Events</h1>
    <?php

    global $wpdb;
    $table_name = $wpdb->prefix . 'events';

	$data = $wpdb->get_results("SELECT * FROM $table_name WHERE date < DATE(NOW()) ORDER BY date DESC");

	echo '<table id="upcoming-table">';
	echo '<thead><tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr></thead>';
	foreach ($data as $row) {
		echo '<tr>';
		echo '<td>' . $row->id . '</td>';
		echo '<td>' . $row->date . '</td>';
		echo '<td>' . $row->occassion . '</td>';
		echo '<td>' . $row->post_title . '</td>';
		echo '<td>' . (get_userdata($row->author) ? get_userdata($row->author)->user_login : 'N/A') . '</td>';
        echo '<td>' . (get_userdata($row->reviewer) ? get_userdata($row->reviewer)->user_login : 'N/A') . '</td>';
		echo '</tr>';
	}
	echo '</table>';

}

?>