import { Component, OnInit } from '@angular/core';
import { PosService } from './post.service';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'admin-app-tambah-pos',
  imports: [CommonModule, FormsModule, RouterModule, ReactiveFormsModule],
  templateUrl: './tambah-pos.component.html',
  styleUrl: './tambah-pos.component.css',
  standalone: true,
})
export class AdminTambahPosComponent implements OnInit {
  postForm!: FormGroup;
  categories: any[] = [];
  selectedFile!: File;

  constructor(private posService: PosService, private fb: FormBuilder) { }

  ngOnInit(): void {
    this.postForm = this.fb.group({
      judul: ['', Validators.required],
      isi: ['', Validators.required],
      kategori: ['', Validators.required],
      gambar: ['', Validators.required],
    });

    this.loadCategories();
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

  // Handle perubahan file gambar
  onFileSelected(event: any) {
    this.selectedFile = event.target.files[0];
  }

  // Kirim data postingan
  submitPost() {
    if (this.postForm.invalid) {
      alert('Silakan lengkapi semua bidang!');
      return;
    }

    const formData = new FormData();
    formData.append('judul', this.postForm.get('judul')?.value);
    formData.append('isi', this.postForm.get('isi')?.value);
    formData.append('kategori', this.postForm.get('kategori')?.value);
    formData.append('gambar', this.selectedFile);

    this.posService.addPost(formData).subscribe(response => {
      if (response.status === 'success') {
        alert('Postingan berhasil ditambahkan!');
        this.postForm.reset();
      } else {
        alert('Gagal menambahkan postingan.');
      }
    });
  }
}
