<?php

namespace App\Http\Controllers\Cardomat;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Cardomat\CardomatCreateRequest;
use App\Http\Requests\Cardomat\CardomatUpdateRequest;
use Illuminate\Http\Request;

class CardomatController extends Controller
{
    /**
     * index
     *
     *  Получение всех продуктов для списка кардоматов
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $cards = Card::all();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'cards' => $cards
        ], 200);
    }

    /**
     * create
     *
     * Создание нового продукта в список покупок и возвращение полного списка покупок вместе с новым продуктом
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function create(CardomatCreateRequest $request): JsonResponse
    {
        $request->validated();

        Card::create([
            'status' => $request->status,
            'address' => $request->address,
            'system_id' => $request->system_id,
            'serial_number' => $request->serial_number,
        ]);

        $cards = Card::all();

        return response()->json([
            'status'=> true,
            'message'=> 'Product successfully updated',
            'cards'=> $cards
        ], 200);
    }
        /**
     * edit
     *
     * Обноваление продукта и возвращение полного списка покупок с обновленным продуктом
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function edit(CardomatUpdateRequest $request): JsonResponse
    {
        $request->validated();

        Card::find($request->id)->update([
            'status' => $request['status'],
            'system_id' => $request['system_id'],
            'address' => $request['address'],
            'serial_number' => $request['serial_number']
        ]);

        $cards = Card::all();

        return response()->json([
            'status'=> true,
            'message'=> 'Product successfully updated',
            'cards'=> $cards
        ], 200);
    }

    public function delete($id)
    {
        $card = Card::find($id);

        if (!$card) {
            return response()->json([
                'status' => false,
                'message' => 'Card not found'
            ], 404);
        }

        $card->delete();

        $cards = Card::all();

        return response()->json([
            'status' => true,
            'message' => 'Card deleted successfully',
            'cards' => $cards
        ]);
    }

    public function getDeletedCards()
    {
        $deletedCards = Card::onlyTrashed()->get();

        return response()->json([
            'status' => true,
            'deletedCards' => $deletedCards,
        ]);
    }

    public function restore($id)
    {
        $deletedCard = Card::withTrashed()->find($id);

        if (!$deletedCard) {
            return response()->json([
                'status' => false,
                'message' => 'Deleted card not found',
            ], 404);
        }

        $deletedCard->restore();

        $deletedCards = Card::onlyTrashed()->get();

        return response()->json([
            'status' => true,
            'deletedCards' => $deletedCards,
        ]);
    }
}
