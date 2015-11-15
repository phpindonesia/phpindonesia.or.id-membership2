<?php $this->layout('layouts::layout-system'); ?>

<?php
$this->append_js(array(
    $this->uri_base_url().'/public/js/app/membership/index.js'
));
?>

<section id="primary" class="content-full-width">

	<div class="full-width-section">

		<div class="container" style="margin-top: -70px;">
			
			<h2 class="aligncenter">Anggota PHP Indonesia</h2>

			<?php
			echo $this->insert('sections::flash-message');
			?>

			<form action="<?php echo $this->uri_path_for('membership-index'); ?>" method="get" class="checkout" novalidate>
				<table>
                    <tbody>
                        <tr>
                            <th>
                                <label for="provinces-dd" style="font-weight: bold;">Provinsi</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('province_id', $provinces, array(
                                    'id' => 'provinces-dd',
                                    'class' => 'input_full'
                                ));
                                ?>
                            </td>

                            <th>
                            	<label for="cities-dd" style="font-weight: bold;">Kabupaten / Kota</label>
                            </th>
                            <td>
                            	<?php
                                echo $this->fh_input_select('city_id', $cities, array(
                                    'id' => 'cities-dd',
                                    'class' => 'input_full'
                                ));
                                ?>
                            </td>
                        </tr>

                        <tr>
                        	<th>
                        		<label for="area" style="font-weight: bold;">Area</label>
                        	</th>
                        	<td>
                        		<input type="text" id="area" class="input_full" name="area" value="<?php echo $this->fh_default_val('area', null, true); ?>" />
                        	</td>
                        	<td>&nbsp;</td>
                        	<td>&nbsp;</td>
                        </tr>

                        <tr>
                        	<td>&nbsp;</td>
                        	<td><input value="Search" type="submit" /></td>
                        	<td>&nbsp;</td>
                        	<td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
			</form>

			<?php
            $no = 1;
            foreach($members as $member):
            ?>

            <?php
            if ($no%4 == 1):
            ?>

            <div class="dt-sc-hr-invisible-small"></div>

            <?php
            endif;
            ?>

            <div class="column dt-sc-one-fourth <?php echo ($no == '1' || $no%4 == 1 ? 'first' : ''); ?>">

                <div class="dt-sc-team">
                    <div class="image">
                        <?php
                        if ($member['photo'] == '' || $member['photo'] == null):
                        ?>

                        <img src="<?php echo $this->uri_base_url().'/public/images/team.png'; ?>" alt="" style="width: 140px; height: 140px;" />
                        
                        <?php
                        else:
                        ?>

                        <img src="<?php echo $this->uri_base_url().'/public/files/photoprofile/'.$member['photo']; ?>" alt="" style="width: 140px; height: 140px;" />
                        
                        <?php
                        endif;
                        ?>

                    </div>

                    <div class="team-details">
                        <h6><a href="<?php echo $this->uri_path_for('membership-detail', array('name' => $member['username'])); ?>"><?php echo $member['fullname']; ?></a></h6>

                        <p>
                            <?php echo $member['province'].', '.$member['city']; ?>
                        </p>

                    </div>

                </div>

            </div>

            <?php
            $no++;
            endforeach;
            ?>

            <div class="pagination" style="text-align:center;">
            <?php
            echo $html_view_pager;
            ?>
            </div>

		</div>

	</div>

</section>
