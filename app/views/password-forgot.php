<?php $this->layout('layouts::system') ?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <h3 class="aligncenter"> <span> <i class="fa fa-key"></i></span> Forgot Password</h3>

        <?php echo $this->insert('sections::flash-message') ?>

        <form action="<?php echo $this->pathFor('membership-password-forgot'); ?>" method="post" novalidate>

            <table style="width: 70%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <th style="width: 100px;">
                            <label style="font-weight: bold;">Email *</label>
                        </th>
                        <td>
                            <input id="email" class="input_full" name="email" type="text" value="<?php echo $this->requestParam('email'); ?>" />

                            <?php
                            echo $this->formShowErrors('email', $validation_errors);
                            ?>

                            <p>
                                Informasi konfirmasi lupa password akan kami kirimkan ke email anda. Demi keamanan
                                dan validitas data maka kami tidak langsung mengirimkan password ke email anda. Tetapi,
                                mengkonfirmasi terlebih dahulu bahwa anda benar-benar secara sadar telah lupa password.
                            </p>
                        </td>
                    </tr>

                </tbody>
            </table>

            <table class="form-oprek" style="width: 70%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td style="width: 100px;">
                        <?php
                        if ($gcaptchaEnable == true):
                        ?>

                        <input id="foo-captcha" name="captcha" type="hidden" value="1" />
                        <?php
                        echo $this->formShowErrors('captcha', $validation_errors);
                        ?>

                        <div class="g-recaptcha" data-sitekey="<?php echo $gcaptchaSitekey; ?>"></div>

                        <?php
                        endif;
                        ?>
                        </td>

                        <td>
                            <input value="Confirm" class="button" type="submit" />
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>

</div>

<div class="full-width-section">
    <div class="container">
        <div class="dt-sc-margin70"></div>
        <div class="page_info aligncenter">
            <h4 class="title">Bantuan Login?</h4>
            <p>Jika belum terdaftar sebagai anggota, <a href="<?php echo $this->pathFor('membership-register'); ?>" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.</p>
        </div>
    </div>
</div>

<div class="dt-sc-margin100"></div>
