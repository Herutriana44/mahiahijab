import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NavbarComponent } from './navbar.component';
import { CommonModule } from '@angular/common';
import { RouterTestingModule } from '@angular/router/testing'; // Untuk testing routerLink

describe('NavbarComponent', () => {
  let component: NavbarComponent;
  let fixture: ComponentFixture<NavbarComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [NavbarComponent], // Menambahkan NavbarComponent ke declarations
      imports: [CommonModule, RouterTestingModule] // Menambahkan CommonModule dan RouterTestingModule
    })
      .compileComponents();

    fixture = TestBed.createComponent(NavbarComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
