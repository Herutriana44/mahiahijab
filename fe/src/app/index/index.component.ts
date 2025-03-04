import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NavbarComponent } from '../navbar/navbar.component';
import { FooterComponent } from '../footer/footer.component';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-index',
  templateUrl: './index.component.html',
  imports: [NavbarComponent, FooterComponent, FormsModule, CommonModule],
  styleUrls: ['./index.component.css'],
  standalone: true,
})
export class IndexComponent implements OnInit {
  
  searchQuery: string = '';
  products: any[] = [];
  categories: any[] = [];

  constructor(private http: HttpClient, public router: Router) { }

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
