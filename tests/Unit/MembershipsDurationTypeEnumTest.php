<?php

use App\Enums\MembershipsDurationTypeEnum;

test('MembershipsDurationTypeEnum has correct values', function () {
    expect(MembershipsDurationTypeEnum::FIXED->value)->toBe('fixed');
    expect(MembershipsDurationTypeEnum::RECURRING->value)->toBe('recurring');
    expect(MembershipsDurationTypeEnum::LIFETIME->value)->toBe('lifetime');
    expect(MembershipsDurationTypeEnum::TRIAL->value)->toBe('trial');
});

test('MembershipsDurationTypeEnum allValues returns all enum values', function () {
    $allValues = MembershipsDurationTypeEnum::allValues();

    expect($allValues)->toBeArray()
        ->toHaveCount(4)
        ->toContain('fixed')
        ->toContain('recurring')
        ->toContain('lifetime')
        ->toContain('trial');
});

test('MembershipsDurationTypeEnum can be instantiated from string', function () {
    $enum = MembershipsDurationTypeEnum::from('fixed');

    expect($enum)->toBeInstanceOf(MembershipsDurationTypeEnum::class)
        ->and($enum)->toBe(MembershipsDurationTypeEnum::FIXED);
});

test('MembershipsDurationTypeEnum tryFrom returns null for invalid value', function () {
    $result = MembershipsDurationTypeEnum::tryFrom('invalid_value');

    expect($result)->toBeNull();
});

test('MembershipsDurationTypeEnum cases returns all enum cases', function () {
    $cases = MembershipsDurationTypeEnum::cases();

    expect($cases)->toHaveCount(4)
        ->and($cases[0])->toBeInstanceOf(MembershipsDurationTypeEnum::class);
});
