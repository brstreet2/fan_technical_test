function hitungJumlahKata(kalimat) 
{
    const kata = kalimat.split(/\s+/);
    const regexValidation = /[!@#$%^&*()_+={}\[\]:;<>~\\|'"]/;
    const kataFilter = kata.filter(kata => !regexValidation.test(kata));
    return kataFilter.length;
}
  const inputA = "Saat meng*ecat tembok, Agung dib_antu oleh Raihan.";
  const inputB = "Berapa u(mur minimal[ untuk !mengurus ktp?";
  const inputC = "Masing-masing anak mendap(atkan uang jajan ya=ng be&rbeda.";
  const outputA = hitungJumlahKata(inputA);
  const outputB = hitungJumlahKata(inputB);
  const outputC = hitungJumlahKata(inputC);
  console.log(`a. ${outputA}\nb. ${outputB}\nc. ${outputC}`);