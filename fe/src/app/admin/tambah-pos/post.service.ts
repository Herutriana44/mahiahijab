import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class PosService {
    private apiUrl = 'http://localhost/mahiahijab/api/admin/pos/pos.php';

    constructor(private http: HttpClient) { }

    // Ambil daftar kategori
    getCategories(): Observable<any> {
        return this.http.get<any>(`${this.apiUrl}?action=getCategories`);
    }

    // Tambah postingan baru (dengan upload gambar)
    addPost(formData: FormData): Observable<any> {
        return this.http.post<any>(this.apiUrl, formData);
    }
}
