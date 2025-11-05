<?php

use App\Enums\MembershipsAccessTypeEnum;

test('MembershipsAccessTypeEnum has correct values', function () {
    expect(MembershipsAccessTypeEnum::PUBLIC->value)->toBe('public');
    expect(MembershipsAccessTypeEnum::MEMBERS_ONLY->value)->toBe('members_only');
    expect(MembershipsAccessTypeEnum::INVITE_ONLY->value)->toBe('invite_only');
    expect(MembershipsAccessTypeEnum::PRIVATE->value)->toBe('private');
});

test('MembershipsAccessTypeEnum allValues returns all enum values', function () {
    $allValues = MembershipsAccessTypeEnum::allValues();

    expect($allValues)->toBeArray()
        ->toHaveCount(4)
        ->toContain('public')
        ->toContain('members_only')
        ->toContain('invite_only')
        ->toContain('private');
});

test('MembershipsAccessTypeEnum can be instantiated from string', function () {
    $enum = MembershipsAccessTypeEnum::from('public');

    expect($enum)->toBeInstanceOf(MembershipsAccessTypeEnum::class)
        ->and($enum)->toBe(MembershipsAccessTypeEnum::PUBLIC);
});

test('MembershipsAccessTypeEnum tryFrom returns null for invalid value', function () {
    $result = MembershipsAccessTypeEnum::tryFrom('invalid_value');

    expect($result)->toBeNull();
});

test('MembershipsAccessTypeEnum cases returns all enum cases', function () {
    $cases = MembershipsAccessTypeEnum::cases();

    expect($cases)->toHaveCount(4)
        ->and($cases[0])->toBeInstanceOf(MembershipsAccessTypeEnum::class);
});
