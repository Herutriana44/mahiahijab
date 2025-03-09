import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { SidebarComponent } from '../left-sidebar/left-sidebar.component';

@Component({
  selector: 'admin-app-add-product',
  templateUrl: './add-product.component.html',
  styleUrls: ['./add-product.component.css'],
  imports: [CommonModule, FormsModule, ReactiveFormsModule, SidebarComponent]
})
export class AdminAddProductComponent {
  productForm: FormGroup;
  previewImage: string | ArrayBuffer | null = '';
  apiUrl = 'http://localhost/mahiahijab/api/admin/product/Product.php';

  constructor(
    private fb: FormBuilder,
    private http: HttpClient,
    private router: Router
  ) {
    this.productForm = this.fb.group({
      id_kategori: ['', Validators.required],
      nama: ['', Validators.required],
      berat: ['', Validators.required],
      harga: ['', Validators.required],
      stok: ['', Validators.required],
      deskripsi: ['', Validators.required],
      img: this.fb.group({ name: '', data: '' }) // Data gambar dalam Base64
    });
  }

  // Fungsi untuk menangani file upload dan konversi ke Base64
  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e: any) => {
        this.productForm.patchValue({
          img: { name: file.name, data: e.target.result.split(',')[1] }
        });
        this.previewImage = e.target.result; // Menampilkan preview
      };
      reader.readAsDataURL(file);
    }
  }

  // Fungsi untuk submit form
  addProduct() {
    if (this.productForm.valid) {
      this.http.post(this.apiUrl, this.productForm.value)
        .subscribe((response: any) => {
          console.log(response);
          if (response.status === 'success') {
            alert('Produk berhasil ditambahkan!');
            this.router.navigate(['/products']);
          } else {
            alert('Gagal menambahkan produk!');
          }
        }, (error) => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat mengirim data.');
        });
    } else {
      alert('Silakan isi semua field dengan benar.');
    }
  }
}
