import { Component, OnInit } from '@angular/core';
import { PostService } from './post.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { SidebarComponent } from '../left-sidebar/left-sidebar.component';

@Component({
  selector: 'admin-app-pos',
  imports: [CommonModule, FormsModule, RouterModule,SidebarComponent],
  templateUrl: './pos.component.html',
  styleUrl: './pos.component.css'
})
export class PosComponent implements OnInit {
  posts: any[] = [];

  constructor(private postService: PostService) { }

  ngOnInit() {
    this.loadPosts();
  }

  loadPosts() {
    this.postService.getPosts().subscribe(
      (response) => {
        if (response.status === 'success') {
          this.posts = response.data;
        } else {
          console.error('Error fetching posts:', response.message);
        }
      },
      (error) => {
        console.error('Error loading posts', error);
      }
    );
  }

  deletePost(id: number) {
    if (confirm('Apakah Anda yakin ingin menghapus postingan ini?')) {
      this.postService.deletePost(id).subscribe(
        (response) => {
          if (response.status === 'success') {
            alert('Postingan berhasil dihapus');
            this.loadPosts();
          } else {
            alert('Gagal menghapus postingan: ' + response.message);
          }
        },
        (error) => {
          console.error('Error deleting post', error);
          alert('Gagal menghapus postingan');
        }
      );
    }
  }
}
