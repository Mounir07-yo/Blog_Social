<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        try {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Stocker l'image dans le dossier public/uploads
            $path = $image->storeAs('uploads', $filename, 'public');
            
            $url = asset('storage/' . $path);
            
            return response()->json([
                'success' => true,
                'url' => $url,
                'filename' => $filename,
                'message' => 'Image téléchargée avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement : ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadMultiple(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'images' => 'max:10' // Maximum 10 images
        ]);

        try {
            $uploadedImages = [];
            
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads', $filename, 'public');
                
                $uploadedImages[] = [
                    'url' => asset('storage/' . $path),
                    'filename' => $filename
                ];
            }
            
            return response()->json([
                'success' => true,
                'images' => $uploadedImages,
                'message' => count($uploadedImages) . ' image(s) téléchargée(s) avec succès'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement : ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        try {
            $filename = $request->filename;
            $path = 'uploads/' . $filename;
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image supprimée avec succès'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Image non trouvée'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ], 500);
        }
    }
}