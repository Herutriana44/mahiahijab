import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';

@Component({
  selector: 'app-shop',
  templateUrl: './shop.component.html',
  styleUrls: ['./shop.component.css'],
  imports: [CommonModule, NavbarComponent, FooterComponent],
  standalone: true
})
export class ShopComponent {
  products: any[] = [];
  categories: any[] = [];
  searchQuery: string = '';

  constructor(private http: HttpClient) { }

  ngOnInit(): void {
    this.fetchProducts();
    this.fetchCategories();
  }

  fetchProducts(category: string = '', search: string = ''): void {
    let url = 'http://localhost/mahiahijab/api/product/categoryProduct.php';
    if (category) {
      url += `?kategori=${category}`;
    } else if (search) {
      url += `?search=${search}`;
    }
    this.http.get<any>(url).subscribe(data => {
      this.products = data['products'];
      this.categories = data['categories'];
    });
    // console.log(this.products);
  }

  fetchCategories(): void {
    this.http.get<any[]>('http://localhost/mahiahijab/api/admin/product/Category.php')
      .subscribe(data => this.categories = data);
  }

  onSearch(): void {
    this.fetchProducts('', this.searchQuery);
  }

  onSelectCategory(category: string): void {
    this.fetchProducts(category);
  }

}
