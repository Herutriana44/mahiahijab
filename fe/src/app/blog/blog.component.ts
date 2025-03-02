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
export class BlogComponent implements OnInit {
  articles: any[] = [];
  filteredArticles: any[] = [];
  categories: string[] = [];
  favoriteArticle: any;

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.fetchCategories();
    this.fetchArticles();
    this.fetchFavoriteArticle();
  }

  fetchArticles(): void {
    this.http.get<any>('http://localhost/mahiahijab/api/article/getArticles.php')
      .subscribe(response => {
        this.articles = response.data;
        this.filteredArticles = [...this.articles]; // Awalnya tampil semua
      });
  }

  fetchFavoriteArticle(): void {
    this.http.get<any>('http://localhost/mahiahijab/api/article/getArticlesByCategory.php?category=diskon')
      .subscribe(response => {
        this.favoriteArticle = response.length ? response[0] : null;
      });
  }

  fetchCategories(): void {
    this.http.get<any>('http://localhost/mahiahijab/api/article/getCategories.php')
      .subscribe(response => {
        this.categories = response.data.map((cat: any) => cat.nm_kategori);
      });
  }

  filterByCategory(event: any): void {
    const selectedCategory = event.target.value;

    if (selectedCategory) {
      this.filteredArticles = this.articles.filter(article => article.nm_kategori === selectedCategory);
    } else {
      this.filteredArticles = [...this.articles]; // Semua artikel
    }
  }
}
