import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';

@Component({
  selector: 'app-blog',
  templateUrl: './blog.component.html',
  styleUrls: ['./blog.component.css'],
  standalone: true,
  imports: [CommonModule, NavbarComponent, FooterComponent],
})
export class BlogComponent {
  articles: any[] = [];  // Untuk bagian atas (3 artikel pertama)
  favoriteArticle: any;  // Untuk bagian tengah (artikel kategori "Desain Ruang Tamu")

  constructor(private http: HttpClient) { }

  ngOnInit(): void {
    this.fetchArticles();
    this.fetchFavoriteArticle();
  }

  // Ambil 3 artikel pertama
  fetchArticles(): void {
    this.http.get<any>('http://localhost/mahiahijab/api/article/getArticles.php')
      .subscribe(data => {
        this.articles = data['data'];
        console.log(this.articles);
      });
  }

  // Ambil artikel berdasarkan kategori "Desain Ruang Tamu"
  fetchFavoriteArticle(): void {
    this.http.get<any>('http://localhost/mahiahijab/api/article/getArticlesByCategory.php?category=diskon')
      .subscribe(data => {
        this.favoriteArticle = data.length ? data[0] : null;
      });
  }
}
