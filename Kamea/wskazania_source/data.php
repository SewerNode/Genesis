<?php

$col1 = array(
    array(
        'name'=> 'Włosy',
        'id'=> 'wlosy',
        'point'=> array('x'=> 200,'y'=> 30)

    ),
    array(
        'name'=> 'Czoło',
        'id'=> 'czolo',
        'point'=>  array('x'=> 230,'y'=> 100)

    ),
    array(
        'name'=> 'Okolice oczu',
        'id'=> 'okolice_oczu',
        'point'=>  array('x'=> 200,'y'=> 160)
    ),
    array(
        'name'=> 'Skronie',
        'id'=> 'skronie',
        'point'=>  array('x'=> 130,'y'=> 160)
    ),
    array(
        'name'=> 'Usta',
        'id'=> 'usta',
        'point'=>  array('x'=> 200,'y'=> 270)
    ),
    array(
        'name'=> 'Nos',
        'id'=> 'nos',
        'point'=>  array('x'=> 230,'y'=> 210)
    ),
    array(
        'name'=> 'Policzki / Owal',
        'id'=> 'policzki_owal',
        'point'=>  array('x'=> 290,'y'=> 230)
    ),
    array(
        'name'=> 'Broda',
        'id'=> 'broda',
        'point'=>  array('x'=> 220,'y'=> 330)
    ),
    array(
        'name'=> 'Szyja',
        'id'=> 'szyja',
        'point'=>  array('x'=> 190,'y'=> 370)
    ),
    array(
        'name'=> 'Skóra twarzy',
        'id'=> 'skora_twarzy',
        'point'=>  array('x'=> 160,'y'=> 230)
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
