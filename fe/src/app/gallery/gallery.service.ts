import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class GalleryService {
    private apiUrl = 'http://localhost/mahiahijab/api/gallery/gallery.php';

    constructor(private http: HttpClient) { }

    getGallery(): Observable<any> {
        return this.http.get<any>(this.apiUrl);
    }
}
