<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'alpha' => ':Attribute sme da sadrži samo slova.',
    'alpha_num' => ':Attribute sme da sadrži samo slova i brojeve.',

    'email' => 'E-mail mora biti validna email adresa.',

    'image' => 'Fajl mora biti slika.',

    'max' => [
        'numeric' => ':Attribute ne sme biti veći od :max.',
        'file' => ':Attribute ne sme biti veća od :max kB.',
        'string' => ':Attribute ne sme biti duži od :max karaktera.',
        'array' => ':Attribute ne sme imati vise od :max elemenata.',
    ],
    'date' => ':Attribute nije validan datum.',
    'string' => ':Attribute mora biti string.',
    'integer' => 'Polje :attribute mora biti broj.',
    'numeric' => 'Polje :attribute mora biti broj.',
    'password' => 'Lozinka nije ispravna.',
    'required' => 'Polje :attribute je obavezno.',
    'unique' => ':Attribute je već zauzeto.',
    'confirmed' => 'Lozinke nisu iste.',
    'subscription' => 'Već ste pretplaćeni.',
    'The :attribute must be at least :length characters.' => ':Attribute mora biti najmanje :length karaktera.',
    'mimes' => ':Attribute mora biti fajl tipa: :values.',
    'encoded-image' => ':Attribute mora biti slika formata:  :values.',
    'staff' => 'Možete kreirati osoblje samo za svoj objekat.',
    'unknown' => 'Nismo uspeli da pronađemo korisnika sa unetim podacima.',
    'bad_category' => 'Greška prilikom izbora kategorije.',
    'uploaded' => ':Attribute nije uspešno dodata. Fajl je možda preveliki. Maksimalno dozvoljeno 2048kB',
    'non_existing_category' => 'Prosledili ste nepostojeću kategoriju!',
    'bad_smoking_choice' => 'Morate izabrati između 2 vrednosti za :attribute.',
    'favorite_place' => 'Objekat je već u omiljenima.',
    'bad_icon' => 'Izaberite ikonicu iz liste.',
    'bad_staff' => 'Greška prilikom izbora zaposlenog.',
    'non_existing_staff' => 'Prosledili ste nepostojećeg zaposlenog!',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'old_password' => 'trenutna lozinka',
        'username' => 'korisničko ime',
        'fname' => 'ime',
        'lname' => 'prezime',
        'bday' => 'rođendan',
        'phone' => 'telefon',
        'password' => 'lozinka',
        'name' => 'naziv',
        'address' => 'adresa',
        'city' => 'grad',
        'category' => 'kategorija',
        'smoking_allowed' => 'izbor za pušenje',
        'icon' => 'ikonica',
        'image' => "slika",
        'images.*' => "slika",
        'category_id' => "kategorija",
        'start_date' => "datum početka",
        'number_of_days' => "broj dana",
        'start_time' => "vreme početka",
        'number_of_hours' => "broj sati",
    ],

];
