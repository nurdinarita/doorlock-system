<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Member;

use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 10;

        if ($search) {
            $members = Member::where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('card_uid', 'like', '%' . $search . '%')
                ->orderBy('name', 'asc')
                ->paginate($perPage)
                ->appends(['search' => $search]);
        }else{
            $members = Member::orderBy('name', 'asc')->paginate($perPage);
        }
        
        return view('members.members', compact('members'));
    }

    public function create()
    {
        return view('members.form');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'image' => 'required|file|image|max:2048',
            'card_uid' => 'required|unique:members,card_uid',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('member_images', 'public');
            $validated['image'] = $imagePath;
        }

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.form', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'image' => 'nullable|file|image|max:2048',
            'card_uid' => 'required|unique:members,card_uid,' . $member->id,
        ]);

        if ($request->hasFile('image')) {
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }
            $imagePath = $request->file('image')->store('member_images', 'public');
            $validated['image'] = $imagePath;
        }

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
