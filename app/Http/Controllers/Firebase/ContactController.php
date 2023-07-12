<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Google\Cloud\Storage\Connection\Rest;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;


class ContactController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'contacts';
    }
    public function index(){

        $contacts = []; // Variable para almacenar los contactos

        // Obtener los contactos de Firebase
        $contactsSnapshot = $this->database->getReference($this->tablename)->getSnapshot();

        if ($contactsSnapshot->exists()) {
            $contacts = $contactsSnapshot->getValue();
        }
        

        return view('firebase.contact.index', compact('contacts'));
    }

    public function store(Request $request){
        
        $postData = [
            'nombre'=>$request->input('nombre'),
            'apellido'=>$request->input('apellido'),
            'telefono'=>$request->input('telefono'),
            'email'=>$request->input('email'),
        ];
        $postRef = $this->database->getReference( $this->tablename)->push($postData);
    
        return redirect()->route('contacts')->with('success', 'El contacto se ha creado correctamente');
    }

    public function update(Request $request, $id){
        $postData = [
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
        ];

        // Actualizar los datos en Firebase
        $contactRef = $this->database->getReference($this->tablename . '/' . $id);
        $contactRef->update($postData);

        return redirect()->route('contacts')->with('success', 'El contacto se ha actualizado correctamente');
    }

    public function destroy(Request $request, $id){
        $this->database->getReference($this->tablename. '/'.$id)->remove();
        return redirect()->route('contacts')->with('success', 'El contacto se ha eliminado correctamente');
    }
}
