import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminKategoriPosComponent } from './kategori-pos.component';

describe('AdminKategoriPosComponent', () => {
  let component: AdminKategoriPosComponent;
  let fixture: ComponentFixture<AdminKategoriPosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminKategoriPosComponent]
    })
      .compileComponents();

    fixture = TestBed.createComponent(AdminKategoriPosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
