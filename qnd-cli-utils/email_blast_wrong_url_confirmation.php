<?php
require 'bootstrap.php';

$db = $container['db'];

$q_users = $db->createQueryBuilder()
->select(
    'usr.user_id',
    'usr.email',
    'u_actv.activation_key',
    'mp.fullname'
)
->from('users_activations', 'u_actv')
->leftJoin('u_actv', 'users', 'usr', 'usr.user_id = u_actv.user_id')
->leftJoin('u_actv', 'members_profiles', 'mp', 'mp.user_id = u_actv.user_id')
->where('DATE(u_actv.expired_date) = :expired')
->setParameter(':expired', '2017-01-01', \Doctrine\DBAL\Types\Type::STRING)
->orderBy('u_actv.user_id', 'ASC')
->execute();

$users = $q_users->fetchAll();
$db->close();

$replacements = array();
foreach ($users as $usr) {

    //
    echo "Preparing: ".$usr['email']."\n";
    //

    $replacements[$usr['email']] = array(
        '{fullname}' => $usr['fullname'],
        '{base_url}' => $container['settings']['base_url'],
        '{activation_path}' => '/apps/membership/activation/'.$usr['user_id'].'/'.$usr['activation_key'],
    );
}

$mailer = $container['mailer'];
$mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
$mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(20,30));

echo "---SENDING EMAIL---\n\n";

foreach ($users as $usr_mail) {
<<<<<<< d79fc03606ba8e7b4f4700daaf9abfc82b2b99cb
    
=======

>>>>>>> Sending email wrong url activation confirmation
    $message = Swift_Message::newInstance('PHP Indonesia - Konfirmasi kesalahan URL aktivasi.')
    ->setFrom(array(
        $container['settings']['email']['sender_email'] => $container['settings']['email']['sender_name']
    ))
    ->setTo(array(
        $usr_mail['email'] => $usr_mail['fullname']
    ))
    ->setBody(file_get_contents('non-code'._DS_.'email_blast_wrong_url.txt'));

    $mailer->send($message);

    echo "Sending email to: {$usr_mail['email']} - OK\n";
    echo "--------------------------------------------------\n\n";
}

echo "Done!\n\n";
<<<<<<< d79fc03606ba8e7b4f4700daaf9abfc82b2b99cb

=======
>>>>>>> Sending email wrong url activation confirmation
