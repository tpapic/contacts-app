<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Contact;
use Auth;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->input();
        $user = Auth::user();
        $query = Contact::query();

        if(isset($filters['favorite']) && $filters['favorite'] === "true") {
          $query->favoriteFilter();
        }
        
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('id', '=', $search);
                $q->orWhere('first_name', 'LIKE', '%' . $search . '%');
                $q->orWhere('last_name', 'LIKE', '%' . $search . '%');
                $q->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $contacts = $query->where('user_id', $user->id)->get();

        return ['success' => true, 'data' => $contacts];
    }

    public function store(ContactRequest $request)
    {
        $user = Auth::user();
        $data = $request->input();

        if(!isset($data['profile_photo']) || empty($data['profile_photo'])) {
          $data['profile_photo'] = 'no_image.png';
        }

        $data['user_id'] = $user->id;

        $contact = Contact::create($data);

        $uniqueNumbers = $this->uniqueCollection($data['numbers']);

        $contact->numbers()->createMany($uniqueNumbers);

        return ['success' => true, 'data' => $contact];
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $this->authorize('view', $contact);

        return ['success' => true, 'data' => $contact];
    }

    public function update(ContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $this->authorize('update', $contact);

        $data = $request->input();

        $contact->update($data);
        $contact->numbers()->delete();

        $uniqueNumbers = $this->uniqueCollection($data['numbers']);

        $contact->numbers()->createMany($uniqueNumbers);

        return ['success' => true, 'data' => $contact];
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $this->authorize('delete', $contact);

        $contact->delete();

        return ['success' => true];
    }

    private function uniqueCollection($data) {
      $collection = collect($data);

      $unique = $collection->unique('number');

      return $unique->values()->all();
    }
}