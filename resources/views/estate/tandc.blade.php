@extends('layouts.estate')
@section('content')
<main>
      
      <!-- breadcrum -->
      <div class="breadcrum">
        <div class="container">
          <h1 class="breadcrumTittle">Terms & Conditions</h1>
        </div>
      </div>
      <!-- Bredacrum Over -->
      
<!-- featured property -->
<!-- <section class="privacy-page space">
    <div class="container">
      <div class="row">
            <div class="col-12">
                <div class="privacy_page">
                <strong>Applicable Terms</strong>
                <div class="tips">
                    <ul>
                        <li>
                            <p>This website (the “Site”) is owned and operated by Estate On, Mumbai, India. </p>
                        </li>
                        <li>
                            <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </li>
                        <li class="mb-0">
                            <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum</p>
                        </li>
                    </ul>
                </div>
                
                <p><strong>Where does it come from?</strong>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                <strong>Liability</strong>
                <div class="tips">
                    <ul>
                        <li>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                        </li>
                        <li>
                            <p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                        </li>
                        <li><p>Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.</p></li>
                        <li><p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.</p></li>
                        <li class="mb-0">
                            <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. </p>
                        </li>
                    </ul>
                </div>
                
                <p><strong>Use of the Site</strong>You agree to use the Site only for lawful purposes, and in a manner that does not infringe the rights of, or restrict or inhibit the use and enjoyment of the Site by any third party. Such restriction or inhibition includes, without limitation, conduct which is unlawful, or which may harass or cause distress or inconvenience to any person and the transmission of obscene or offensive content or disruption of normal flow of dialogue within the Site.</p>
                
                <p><strong>Where can I get some?</strong>If any of these Terms and Conditions should be determined to be illegal, invalid or otherwise unenforceable by reason of the laws of any state or country in which these Terms and Conditions are intended to be effective, then to the extent and within the jurisdiction which that term or condition is illegal, invalid or unenforceable, it shall be severed and deleted from these Terms and Conditions and the remaining terms and conditions shall survive, remain in full force and effect and continue to be binding and enforceable.</p>
                
                <p><strong>What is Lorem Ipsum?</strong>The Site is controlled and operated by Wadhim Solutions from its offices. Wadhim Solutions makes no representation that materials on the Site are appropriate or available for use in other locations. Those who choose to access the Site from other locations do so on their own initiative and are responsible for compliance with local laws, if and to the extent local laws are applicable.</p>
            </div>
        </div>
      </div>
    </div>
  </section> -->

    {!!html_entity_decode($content->content)!!}
    </main>
@endsection