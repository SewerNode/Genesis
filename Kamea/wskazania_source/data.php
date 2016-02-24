<?php

$col1 = array(
    array(
        'name'=> 'Włosy',
        'id'=> 'wlosy',
        'point'=> array('x'=> 200,'y'=> 50)

    ),
    array(
        'name'=> 'Czoło',
        'id'=> 'czolo',
        'point'=>  array('x'=> 200,'y'=> 100)

    ),
    array(
        'name'=> 'Okolice oczu',
        'id'=> 'okolice_oczu',
        'point'=>  array('x'=> 200,'y'=> 150)
    ),
    array(
        'name'=> 'Skronie',
        'id'=> 'skronie',
        'point'=>  array('x'=> 200,'y'=> 200)
    ),
    array(
        'name'=> 'Usta',
        'id'=> 'usta',
        'point'=>  array('x'=> 200,'y'=> 250)
    ),
    array(
        'name'=> 'Nos',
        'id'=> 'nos',
        'point'=>  array('x'=> 200,'y'=> 300)
    ),
    array(
        'name'=> 'Policzki / Owal',
        'id'=> 'policzki_owal',
        'point'=>  array('x'=> 200,'y'=> 350)
    ),
    array(
        'name'=> 'Broda',
        'id'=> 'broda',
        'point'=>  array('x'=> 220,'y'=> 280)
    ),
    array(
        'name'=> 'Szyja',
        'id'=> 'szyja',
        'point'=>  array('x'=> 150,'y'=> 200)
    ),
    array(
        'name'=> 'Skóra twarzy',
        'id'=> 'skora_twarzy',
        'point'=>  array('x'=> 300,'y'=> 300)
    )
);

$col2 = array(
    array(
        'name'=> 'Bruzdy nosowo-wargowe',
        'id'=> 'bruzdy_nosowo_wargowe',
        'parent'=> 'policzki_owal'
    ),
    array(
        'name'=> 'Siateczka drobnych zmarszczek',
        'id'=> 'siateczka_drobnych_zmarszczek',
        'parent'=> 'policzki_owal'
    ),
    array(
        'name'=> 'Linie marionetki',
        'id'=> 'linie_marionetki',
        'parent'=> 'policzki_owal'
    ),
    array(
        'name'=> 'Opadajace rysy twarzy, utrata owalu',
        'id'=> 'opadajace_rysy_twarzy',
        'parent'=> 'policzki_owal'
    ),
    array(
        'name'=> 'Rozszerzone naczynka, rumień',
        'id'=> 'naczynka',
        'parent'=> 'okolice_oczu'
    ),
    array(
        'name'=> 'Zbędne owłosienie',
        'id'=> 'zbedne_owlosienie',
        'parent'=> 'okolice_oczu'
    ),
);

$col3 = array(
    array(
        'name'=> 'Restylane Skinboosters',
        'id'=> 'restylane',
        'parent'=> 'linie_marionetki',
        'href'=> '/restylane'
    ),
    array(
        'name'=> 'Wypełnianie kwasem hialuronowym',
        'id'=> 'wypenianie_kwasem_hialuronowym',
        'parent'=> 'linie_marionetki',
        'href'=> '/wypenianie-kwasem-hialuronowym'
    ),
    array(
        'name'=> 'Elektrokoagulacja',
        'id'=> 'Elektrokoagulacja',
        'parent'=> 'zbedne_owlosienie',
        'href'=> '/wypenianie-kwasem-hialuronowym'
    ),
    array(
        'name'=> 'Skleroterapia',
        'id'=> 'skleroterapia',
        'parent'=> 'zbedne_owlosienie',
        'href'=> '/skleroterapia'
    )
);
