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

    'accepted' => 'Поле :attribute повинно бути прийнято.',
    'accepted_if' => 'Поле :attribute повинно бути прийнято, коли :other є :value.',
    'active_url' => 'Поле :attribute повинно бути дійсним URL.',
    'after' => 'Поле :attribute повинно бути датою після :date.',
    'after_or_equal' => 'Поле :attribute повинно бути датою після або рівною :date.',
    'alpha' => 'Поле :attribute повинно містити лише букви.',
    'alpha_dash' => 'Поле :attribute повинно містити лише букви, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute повинно містити лише букви та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',
    'ascii' => 'Поле :attribute повинно містити лише однобайтові алфавітно-цифрові символи та символи.',
    'before' => 'Поле :attribute повинно бути датою до :date.',
    'before_or_equal' => 'Поле :attribute повинно бути датою до або рівною :date.',
    'between' => [
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
        'file' => 'Поле :attribute повинно бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute повинно бути між :min та :max.',
        'string' => 'Поле :attribute повинно містити від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute повинно бути істинним або хибним.',
    'can' => 'Поле :attribute містить несанкціоноване значення.',
    'confirmed' => 'Підтвердження для :attribute не співпадає.',
    'contains' => 'Поле :attribute відсутня обовя’зкова вартість.',
'current_password' => 'Пароль неправильний.',
'date' => 'Поле :attribute повинно бути дійсною датою.',
'date_equals' => 'Поле :attribute повинно бути датою, рівною :date.',
'date_format' => 'Поле :attribute повинно відповідати формату :format.',
'decimal' => 'Поле :attribute повинно мати :decimal десяткових знаків.',
'declined' => 'Поле :attribute повинно бути відхилено.',
'declined_if' => 'Поле :attribute повинно бути відхилено, коли :other є :value.',
'different' => 'Поле :attribute та :other повинні бути різними.',
'digits' => 'Поле :attribute повинно бути :digits цифр.',
'digits_between' => 'Поле :attribute повинно бути між :min та :max цифрами.',
'dimensions' => 'Поле :attribute має недійсні розміри зображення.',
'distinct' => 'Поле :attribute має повторюване значення.',
'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися одним з наступних: :values.',
'doesnt_start_with' => 'Поле :attribute не повинно починатися з одного з наступних: :values.',
'email' => 'Поле :attribute повинно бути дійсною електронною поштою.',
'ends_with' => 'Поле :attribute повинно закінчуватися одним з наступних: :values.',
'enum' => 'Обраний :attribute недійсний.',
'exists' => 'Обраний :attribute недійсний.',
'extensions' => 'Поле :attribute повинно мати один з наступних розширень: :values.',
'file' => 'Поле :attribute повинно бути файлом.',
'filled' => 'Поле :attribute повинно мати значення.',
'gt' => [
    'array' => 'Поле :attribute повинно містити більше ніж :value елементів.',
    'file' => 'Поле :attribute повинно бути більшим ніж :value кілобайт.',
    'numeric' => 'Поле :attribute повинно бути більшим ніж :value.',
    'string' => 'Поле :attribute повинно бути більшим ніж :value символів.',
],
'gte' => [
    'array' => 'Поле :attribute повинно містити :value елементів або більше.',
    'file' => 'Поле :attribute повинно бути більшим або рівним :value кілобайт.',
    'numeric' => 'Поле :attribute повинно бути більшим або рівним :value.',
    'string' => 'Поле :attribute повинно бути більшим або рівним :value символам.',
],
'hex_color' => 'Поле :attribute повинно бути дійсним шістнадцятковим кольором.',
'image' => 'Поле :attribute повинно бути зображенням.',
'in' => 'Обраний :attribute недійсний.',
'in_array' => 'Поле :attribute повинно існувати в :other.',
'integer' => 'Поле :attribute повинно бути цілим числом.',
'ip' => 'Поле :attribute повинно бути дійсною IP адресою.',
'ipv4' => 'Поле :attribute повинно бути дійсною IPv4 адресою.',
'ipv6' => 'Поле :attribute повинно бути дійсною IPv6 адресою.',
'json' => 'Поле :attribute повинно бути дійсним рядком JSON.',
'list' => 'Поле :attribute повинно бути списком.',
'lowercase' => 'Поле :attribute повинно бути в нижньому регістрі.',
'lt' => [
    'array' => 'Поле :attribute повинно містити менше ніж :value елементів.',
    'file' => 'Поле :attribute повинно бути меншим ніж :value кілобайт.',
    'numeric' => 'Поле :attribute повинно бути меншим ніж :value.',
    'string' => 'Поле :attribute повинно бути меншим ніж :value символів.',
],
'lte' => [
    'array' => 'Поле :attribute не повинно містити більше ніж :value елементів.',
    'file' => 'Поле :attribute повинно бути меншим або рівним :value кілобайт.',
    'numeric' => 'Поле :attribute повинно бути меншим або рівним :value.',
    'string' => 'Поле :attribute повинно бути меншим або рівним :value символам.',
],
'mac_address' => 'Поле :attribute повинно бути дійсною MAC адресою.',
'max' => [
    'array' => 'Поле :attribute не повинно містити більше ніж :max елементів.',
    'file' => 'Поле :attribute не повинно бути більшим ніж :max кілобайт.',
    'numeric' => 'Поле :attribute не повинно бути більшим ніж :max.',
    'string' => 'Поле :attribute не повинно бути більшим ніж :max символів.',
],
'max_digits' => 'Поле :attribute не повинно містити більше ніж :max цифр.',
'mimes' => 'Поле :attribute повинно бути файлом типу: :values.',
'mimetypes' => 'Поле :attribute повинно бути файлом типу: :values.',
'min' => [
    'array' => 'Поле :attribute повинно містити щонайменше :min елементів.',
    'file' => 'Поле :attribute повинно бути щонайменше :min кілобайт.',
    'numeric' => 'Поле :attribute повинно бути щонайменше :min.',
    'string' => 'Поле :attribute повинно містити щонайменше :min символів.',
],
'min_digits' => 'Поле :attribute повинно містити щонайменше :min цифр.',
'missing' => 'Поле :attribute повинно бути відсутнім.',
'missing_if' => 'Поле :attribute повинно бути відсутнім, коли :other є :value.',
'missing_unless' => 'Поле :attribute повинно бути відсутнім, якщо :other не є :value.',
'missing_with' => 'Поле :attribute повинно бути відсутнім, коли :values присутній.',
'missing_with_all' => 'Поле :attribute повинно бути відсутнім, коли :values присутні.',
'multiple_of' => 'Поле :attribute повинно бути кратним :value.',
'not_in' => 'Обраний :attribute недійсний.',
'not_regex' => 'Формат поля :attribute недійсний.',
'numeric' => 'Поле :attribute повинно бути числом.',
'password' => [
    'letters' => 'Поле :attribute повинно містити хоча б одну літеру.',
    'mixed' => 'Поле :attribute повинно містити хоча б одну велику і одну малу літеру.',
    'numbers' => 'Поле :attribute повинно містити хоча б одну цифру.',
    'symbols' => 'Поле :attribute повинно містити хоча б один символ.',
    'uncompromised' => 'Значення :attribute використовувалося в зламі даних. Виберіть інший :attribute.',
],
'present' => 'Поле :attribute повинно бути присутнім.',
'present_if' => 'Поле :attribute повинно бути присутнім, коли :other є :value.',
'present_unless' => 'Поле :attribute повинно бути присутнім, якщо :other не є :value.',
'present_with' => 'Поле :attribute повинно бути присутнім, коли :values присутнє.',
'present_with_all' => 'Поле :attribute повинно бути присутнім, коли :values присутні.',
'prohibited' => 'Поле :attribute заборонено.',
'prohibited_if' => 'Поле :attribute заборонено, коли :other є :value.',
'prohibited_unless' => 'Поле :attribute заборонено, якщо :other не в :values.',
'prohibits' => 'Поле :attribute забороняє присутність :other.',
'regex' => 'Формат поля :attribute недійсний.',
'required' => 'Поле :attribute обов’язкове.',
'required_array_keys' => 'Поле :attribute повинно містити записи для: :values.',
'required_if' => 'Поле :attribute обов’язкове, коли :other є :value.',
'required_if_accepted' => 'Поле :attribute обов’язкове, коли :other прийнято.',
'required_if_declined' => 'Поле :attribute обов’язкове, коли :other відхилено.',
'required_unless' => 'Поле :attribute обов’язкове, якщо :other не в :values.',
'required_with' => 'Поле :attribute обов’язкове, коли :values присутнє.',
'required_with_all' => 'Поле :attribute обов’язкове, коли :values присутні.',
'required_without' => 'Поле :attribute обов’язкове, коли :values відсутнє.',
'required_without_all' => 'Поле :attribute обов’язкове, коли жоден з :values не присутній.',
'same' => 'Поле :attribute повинно співпадати з :other.',
'size' => [
    'array' => 'Поле :attribute повинно містити :size елементів.',
    'file' => 'Поле :attribute повинно бути :size кілобайт.',
    'numeric' => 'Поле :attribute повинно бути :size.',
    'string' => 'Поле :attribute повинно бути :size символів.',
],
'starts_with' => 'Поле :attribute повинно починатися з одного з наступних: :values.',
'string' => 'Поле :attribute повинно бути рядком.',
'timezone' => 'Поле :attribute повинно бути дійсною часовою зоною.',
'unique' => 'Поле :attribute вже зайняте.',
'uploaded' => 'Не вдалося завантажити :attribute.',
'uppercase' => 'Поле :attribute повинно бути у верхньому регістрі.',
'url' => 'Поле :attribute повинно бути дійсним URL.',
'ulid' => 'Поле :attribute повинно бути дійсним ULID.',
'uuid' => 'Поле :attribute повинно бути дійсним UUID.',

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

    'attributes' => [],

];
