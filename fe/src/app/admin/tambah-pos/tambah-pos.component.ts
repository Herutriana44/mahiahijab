import { Component, OnInit } from '@angular/core';
import { PosService } from './post.service';
import { AbstractControl, FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { SidebarComponent } from '../left-sidebar/left-sidebar.component';

@Component({
  selector: 'admin-app-tambah-pos',
  imports: [CommonModule, FormsModule, RouterModule, ReactiveFormsModule, SidebarComponent],
  templateUrl: './tambah-pos.component.html',
  styleUrl: './tambah-pos.component.css',
  standalone: true,
})
export class AdminTambahPosComponent implements OnInit {
  postForm!: FormGroup;
  categories: any[] = [];
  base64Image: string = ''; // Menyimpan gambar dalam format Base64

  constructor(private posService: PosService, private fb: FormBuilder) { }

  ngOnInit(): void {
    this.postForm = this.fb.group({
      judul: ['', Validators.required],
      isi: ['', Validators.required],
      kategori: ['', Validators.required],
      gambar: [''],
    });

    this.loadCategories();
  }

  base64Validator(control: AbstractControl) {
    const value = control.value;
    if (!value || !value.startsWith('data:image/')) {
      return { invalidBase64: true };
    }
    return null;
  }

  // Ambil data kategori dari API
  loadCategories() {
    this.posService.getCategories().subscribe(response => {
      if (response.status === 'success') {
        this.categories = response.data;
      } else {
        console.error('Gagal mengambil kategori');
      }
    });
  }

  // Handle perubahan file gambar dan konversi ke Base64
  onFileSelected(event: any) {
    const file: File = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        this.base64Image = reader.result as string;
      };
      reader.readAsDataURL(file); // Konversi ke Base64
    }
  }

  // Kirim data postingan
  submitPost() {
    console.log('Form Status:', this.postForm.status);
    console.log('Form Values:', this.postForm.value);
    console.log({
      judul: this.postForm.get('judul')?.value,
      isi: this.postForm.get('isi')?.value,
      kategori: this.postForm.get('kategori')?.value,
      gambar: this.base64Image // ✅ Pastikan gambar dikirim
    });

    if (this.postForm.invalid) {
      alert('Form masih tidak valid!');
      return;
    }

    if (this.base64Image == "") {
      alert('Harap upload gambar terlebih dahulu!');
      return;
    }

    const postData = {
      judul: this.postForm.get('judul')?.value,
      isi: this.postForm.get('isi')?.value,
      kategori: this.postForm.get('kategori')?.value,
      gambar: this.base64Image // ✅ Pastikan gambar dikirim
    };

    this.posService.addPost(postData).subscribe(response => {
      alert(response);
      if (response.status === 'success') {
        alert('Postingan berhasil ditambahkan!');
        this.postForm.reset();
      } else {
        alert('Gagal menambahkan postingan.');
      }
    });
  }

  convertToBase64(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => {
        this.base64Image = reader.result as string;
        this.postForm.controls['gambar'].setValue(this.base64Image); // ✅ Paksa nilai form diperbarui
        this.postForm.controls['gambar'].updateValueAndValidity();  // ✅ Pastikan validasi berjalan
        console.log('Base64:', this.base64Image);
      };
    }
  }


}
