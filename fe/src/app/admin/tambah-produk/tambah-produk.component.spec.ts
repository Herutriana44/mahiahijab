import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TambahProdukComponent } from './tambah-produk.component';

describe('TambahProdukComponent', () => {
  let component: TambahProdukComponent;
  let fixture: ComponentFixture<TambahProdukComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [TambahProdukComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TambahProdukComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
