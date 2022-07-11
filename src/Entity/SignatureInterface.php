<?php

declare(strict_types=1);

namespace App\Entity;

interface SignatureInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getSurname(): string;

    public function setSurname(string $surname): void;

    public function getAttachment(): ?string;

    public function setAttachment(?string $attachment): void;
}
