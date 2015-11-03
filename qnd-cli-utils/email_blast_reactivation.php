<?php
require 'bootstrap.php';

$db = $container['db'];

/*
 * Ambil semua data member yang belum aktif oleh karena
 * tidak mendapatkan email aktivasi yg berisi link aktivasi.
 * 
*/
$q_users = $db->createQueryBuilder()
->select(
    'u_actv.user_activation_id',
    'usr.user_id',
    'usr.username',
    'usr.email',
    'usr.created',
    'mp.fullname'
)
->from('users_activations', 'u_actv')
->leftJoin('u_actv', 'users', 'usr', 'usr.user_id = u_actv.user_id')
->leftJoin('u_actv', 'members_profiles', 'mp', 'mp.user_id = u_actv.user_id')
->where('u_actv.expired_date < NOW()')
->andWhere('u_actv.deleted = :deleted')
->andWhere('usr.activated = :actv')
->setParameter(':deleted', 'N', \Doctrine\DBAL\Types\Type::STRING)
->setParameter(':actv', 'N', \Doctrine\DBAL\Types\Type::STRING)
->setFirstResult(0)
->setMaxResults(2)
->orderBy('u_actv.user_id', 'ASC')
->execute();

$total_not_activated = $q_users->rowCount();
$users = $q_users->fetchAll();
$db->close();

/*
 * Generate data aktivasi
*/
$activation_expired_date = '2017-01-01 00:00:00';
$replacements = array();
$num = 1;

echo "---PREPARING DATA---\n\n";

foreach ($users as $usr) {

    //
    echo "Data ".$num."\n";
    echo "Insert account: ".$usr['email']." to resend activation data\n\n";
    //

    $activation_key = md5(uniqid(rand(), true));
    $replacements[$usr['email']] = array(
        '{fullname}' => $usr['fullname'],
        '{base_url}' => $container['settings']['base_url'],
        '{activation_path}' => '/apps/membership/activation/'.$usr['user_id'].'/'.$activation_key,
        '{registration_date}' => $usr['created'],
        '{username}' => $usr['username'],
        '{email}' => $usr['email']
    );

    // Insert new activation row
    $db->insert('users_activations', array(
        'user_id' => $usr['user_id'],
        'activation_key' => $activation_key,
        'expired_date' => $activation_expired_date,
        'created' => date('Y-m-d H:i:s')
    ));

    // Delete previous activation row
    $db->update('users_activations', array('deleted' => 'Y'), array(
        'user_activation_id' => $usr['user_activation_id']
    ));

    $db->close();
    $num++;
}

$mailer = $container['mailer'];
$mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
$mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(20,30));

echo "---SENDING EMAIL---\n\n";

foreach ($users as $usr_mail) {
    
    $message = Swift_Message::newInstance('PHP Indonesia - Membership Account Activation Resend')
    ->setFrom(array($container['settings']['email']['sender_email'] => $container['settings']['email']['sender_name']))
    ->setTo(array($usr_mail['email'] => $usr_mail['fullname']))
    ->setBody(file_get_contents('non-code'._DS_.'email_blast_reactivation_words.txt'));

    $mailer->send($message);

    echo "Sending email to: {$usr_mail['email']} - OK\n";
    echo "--------------------------------------------------\n\n";
}

echo "Done!\n\n";
