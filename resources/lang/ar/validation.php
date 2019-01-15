<?php

return array(
    'accepted' => 'يجب قبول :attribute',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون :attribute ًمصفوفة',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' =>
        array(
            'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
            'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
            'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
            'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
        ),
    'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false ',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date' => ':attribute ليس تاريخًا صحيحًا',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام ',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'exists' => ':attribute لاغٍ',
    'file' => 'الـ :attribute يجب أن يكون ملفا.',
    'filled' => ':attribute إجباري',
    'image' => 'يجب أن يكون :attribute صورةً',
    'in' => ':attribute لاغٍ',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيحًا',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json' => 'يجب أن يكون :attribute نصآ من نوع JSON.',
    'max' =>
        array(
            'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر لـ :max.',
            'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
            'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
            'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
        ),
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' =>
        array(
            'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر لـ :min.',
            'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
            'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
            'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
        ),
    'not_in' => ':attribute لاغٍ',
    'numeric' => 'يجب على :attribute أن يكون رقمًا',
    'present' => 'يجب تقديم :attribute',
    'regex' => 'صيغة :attribute .غير صحيحة',
    'required' => ':attribute مطلوب.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
    'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other',
    'size' =>
        array(
            'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
            'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
            'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
            'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
        ),
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => 'قيمة :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل الـ :attribute',
    'url' => 'صيغة الرابط :attribute غير صحيحة',
    'custom' =>
        array(
            'attribute-name' =>
                array(
                    'rule-name' => 'custom-message',
                ),
        ),
    'attributes' =>
        array(
            'name' => 'الاسم',
            'username' => 'اسم المُستخدم',
            'email' => 'البريد الالكتروني',
            'first_name' => 'الاسم الأول',
            'last_name' => 'اسم العائلة',
            'password' => 'كلمة السر',
            'password_confirmation' => 'تأكيد كلمة السر',
            'city' => 'المدينة',
            'country' => 'الدولة',
            'address' => 'عنوان السكن',
            'phone' => 'الهاتف',
            'mobile' => 'الجوال',
            'age' => 'العمر',
            'sex' => 'الجنس',
            'gender' => 'النوع',
            'day' => 'اليوم',
            'month' => 'الشهر',
            'year' => 'السنة',
            'hour' => 'ساعة',
            'minute' => 'دقيقة',
            'second' => 'ثانية',
            'title' => 'العنوان',
            'content' => 'المُحتوى',
            'description' => 'الوصف',
            'excerpt' => 'المُلخص',
            'date' => 'التاريخ',
            'time' => 'الوقت',
            'available' => 'مُتاح',
            'size' => 'الحجم',

            'title_ar' => 'العنوان بالعربية',
            'title_en' => 'العنوان بالانكليزية',
            'location_ar' => 'الموقع بالعربية',
            'description_ar' => 'الشرح بالعربية',
            'image_path' => 'الصورة مطلوبة',
            'sub_title_ar' => 'العنوان الفرعي بالعربية',
            'content_ar' => 'المحتوى بالعربية',
            'name_ar' => 'الاسم بالعربية',
            'bio' => 'اللمحة المختصرة',
            'cv' => 'السيرة الذاتية',
            'specialty' => 'الاختصاص',

        ),
);