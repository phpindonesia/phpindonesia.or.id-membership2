<?php
$this->layout('layouts::system');

$this->appendJs([
    $this->asset('/js/skill.js')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <h3 style="border-bottom: 1px #000000 solid;">Add new techno skill item</h3>

        <?php echo $this->insert('sections::alert') ?>

        <p style="color: blue; font-weight: bold;">
            Jika <strong>Skill Global</strong> tidak memunculkan <strong>Spesific Item</strong>, Maka silahkan langsung saja nilai menggunakan skill global.
        </p>

        <form action="<?php echo $this->pathFor('membership-skills-create'); ?>" method="post" class="checkout" novalidate>

            <table class="form-oprek">
                <tbody>
                    <tr>
                        <th>
                            <label for="skill-parent-id" style="font-weight: bold;">Skill Global</label>
                        </th>
                        <td>
                            <?php
                            echo $this->formInputSelect('skill_parent_id', $skills_main, array(
                                'id' => 'skill-parent-id',
                                'class' => 'input_full'
                            ));

                            echo $this->formFieldError('skill_parent_id');
                            ?>
                        </td>
                    </tr>

                    <?php
                    $style_skill_row = $skills ? ' style="display:auto;"' : ' style="display:none;"';
                    ?>

                    <tr id="skill-id-row"<?php echo $style_skill_row; ?>>
                        <th>
                            <label for="skill-id-dd" style="font-weight: bold;">Spesific Item</label>
                        </th>

                        <td>
                        <?php
                        echo $this->formInputSelect('skill_id', $skills, array(
                            'id' => 'skill-id-dd',
                            'class' => 'input_full'
                        ));

                        echo $this->formFieldError('skill_id');
                        ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="self-assess" style="font-weight: bold;">Self Assessment</label>
                        </th>
                        <td>
                            <ul class="assessm">
                                <li>
                                    <input name="skill_self_assesment" value="1" type="radio">
                                    <label>1</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="2" type="radio">
                                    <label>2</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="3" type="radio">
                                    <label>3</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="4" type="radio">
                                    <label>4</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="5" type="radio">
                                    <label>5</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="6" type="radio">
                                    <label>6</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="7" type="radio">
                                    <label>7</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="8" type="radio">
                                    <label>8</label>
                                </li>

                                <li>
                                    <input name="skill_self_assesment" value="9" type="radio">
                                    <label>9</label>
                                </li>
                            </ul>

                            <div style="clear: both; margin-top: 30px;">
                                <?php echo $this->formFieldError('skill_self_assesment'); ?>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <th>
                            &nbsp;
                        </th>
                        <td>
                            <input type="submit" class="button" value="Simpan" />
                            <button type="button" onclick="location.href='<?php echo $this->pathFor('membership-account'); ?>';">Cancel and Back</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>

</div>
