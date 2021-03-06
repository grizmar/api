<?php

namespace Elantha\Api\Tests\Controllers;

use Elantha\Api\Controllers\BaseController;
use Elantha\Api\Exceptions\ApiException;
use Elantha\Api\Http\Exceptions\EmptyException;
use Elantha\Api\Http\Exceptions\ForbiddenException;
use Elantha\Api\Http\Exceptions\NotFoundException;
use Elantha\Api\Tests\Errors\CodeRegistry;

class TestController extends BaseController
{
    protected function initValidationRules(): array
    {
        return [
            'testValidationErrors' => [
                'one' => 'required|max:6',
                'two' => 'required',
            ],
            'testValidationRules' => [
                'one'   => 'required',
                'two'   => 'required|alpha_num|size:10',
                'three' => 'required|numeric',
            ],
        ];
    }

    public function testResponseContent()
    {
        $this->output('level1.level2.one', 'value');
        $this->output('level1.level2.two', 100);

        return \response()->rest($this->response);
    }

    public function testExceptionWithResponse(): void
    {
        $this->response->setData(['info' => ['one' => 'value']]);

        $this->output('info.two', 0.15);

        throw ForbiddenException::make()->setResponse($this->response);
    }

    public function testEmptyException(): void
    {
        $this->output('param', 'value');

        throw EmptyException::make()->setResponse($this->response);
    }

    public function testExceptionErrors(): void
    {
        throw NotFoundException::make(CodeRegistry::USER_NOT_FOUND, ['name' => 'Jack']);
    }

    public function testCustomAdditionalErrors(): void
    {
        $this->error(CodeRegistry::USER_NOT_FOUND, 'User not found');
        $this->error(100, 'Custom error');

        throw NotFoundException::make()
            ->withoutMessage()
            ->setResponse($this->response);
    }

    public function testResolvedAdditionalErrors(): void
    {
        $this->error(CodeRegistry::USER_NOT_FOUND, null, ['name' => 'Jack']);
        $this->error(100, null);

        throw NotFoundException::make()
            ->withoutMessage()
            ->setResponse($this->response);
    }

    public function testValidationErrors(): void
    {
        throw new ApiException('This method should not be called!');
    }

    public function testValidationRules()
    {
        $this->output('one', $this->input('one'));

        return \response()->rest($this->response);
    }
}
